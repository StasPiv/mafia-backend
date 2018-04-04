<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:06
 */

namespace CoreBundle\Handler;


use CoreBundle\Model\Director;
use CoreBundle\Model\Game;
use CoreBundle\Model\GameAnalyzer;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;
use Doctrine\Common\Collections\Collection;

class Scenario
{
    /**
     * @param Director $director
     * @param Game $game
     * @param GameAnalyzer $gameAnalyzer
     * @param array $moves
     */
    public function process(Director $director, Game $game, GameAnalyzer $gameAnalyzer, array $moves)
    {
        $roundCounter = 0;

        do {
            $roundMoves = $moves[$roundCounter];

            if (!$this->performRoundMoves($director, $game, $gameAnalyzer, $roundMoves, $roundCounter)) {
                break;
            }

            $roundCounter++;
        } while (!$game->isFinished());
    }

    /**
     * @param Director $director
     * @param Game $game
     * @param GameAnalyzer $gameAnalyzer
     * @param array $roundMoves
     * @param int $roundCounter
     *
     * @return bool
     */
    public function performRoundMoves(Director $director, Game $game, GameAnalyzer $gameAnalyzer, array $roundMoves, int $roundCounter): bool
    {
        $this->resetUsers($game);

        $this->performNightActionsForAllGroups($director, $game, $roundMoves['night'], $roundCounter);
        $gameAnalyzer->analyzeNight($game);

        if ($game->isFinished()) {
            return false;
        }

        $this->performTalkForAllUsers($director, $game);
        $this->performVoteForAllUsers($director, $game, $roundMoves['day'], $roundCounter);

        $gameAnalyzer->analyzeDay($game);

        if ($game->isFinished()) {
            return false;
        }

        return true;
    }

    /**
     * @param Game $game
     * @param NightUserGroup $nightUserGroup
     * @param array $nightMoves
     * @param int $roundCounter
     */
    private function performNightActions(Game $game, NightUserGroup $nightUserGroup, array $nightMoves, int $roundCounter)
    {
        if (!$nightUserGroup->isGroupAlive()) {
            return;
        }

        foreach ($nightUserGroup->getNightActions() as $action) {
            /** @var Collection|User[] $destinationUsers */

            $userNames = $nightMoves[$nightUserGroup->getName()];

            foreach ($userNames as $userName) {
                /** @var User $gameUser */
                $gameUser = $game->getUsers()->filter(
                    function (User $user) use ($userName) {
                        return $user->getName() === $userName;
                    }
                )->first();

                if (!$gameUser) {
                    throw new \RuntimeException(sprintf('%s can not make action against unexisting user %s', $nightUserGroup, $userName));
                }

                if (!$gameUser->isAlive()) {
                    throw new \RuntimeException(
                        sprintf(
                            '%s can not make action against dead user %s. Round %d',
                                $nightUserGroup,
                                $userName,
                                $roundCounter
                        )
                    );
                }
            }

            $destinationUsers = $game->getAliveUsers()->filter(
                function (User $user) use ($userNames) {
                    return in_array($user->getName(), $userNames);
                }
            );

            $result = $action->execute($nightUserGroup, $destinationUsers);

            echo $result . PHP_EOL;
        }
    }

    /**
     * @param Game $game
     * @param User $votingUser
     * @param string $nameAgainst
     * @param int $roundCounter
     */
    private function performVote(Game $game, User $votingUser, string $nameAgainst, int $roundCounter)
    {
        /** @var User $userAgainst */
        $userAgainst = $game->getAliveUsers()->filter(
            function (User $user) use ($votingUser, $nameAgainst) {
                return $user->getName() === $nameAgainst;
            }
        )->first();

        if (!$userAgainst) {
            throw new \RuntimeException(sprintf('There is no alive user with name %s. Round: %d, Voting user: %s', $nameAgainst, $roundCounter, $votingUser->getName()));
        }

        $votingUser->vote($userAgainst);
    }

    /**
     * @param Director $director
     * @param Game $game
     * @param array $nightMoves
     * @param int $roundCounter
     */
    public function performNightActionsForAllGroups(Director $director, Game $game, array $nightMoves, int $roundCounter)
    {
        foreach ($game->getNightUserGroups() as $nightUserGroup) {
            $director->askAboutNightAction($nightUserGroup);

            $this->performNightActions($game, $nightUserGroup, $nightMoves, $roundCounter);
        }
    }

    /**
     * @param Director $director
     * @param Game $game
     * @param array $dayMoves
     * @param int $roundCounter
     */
    public function performVoteForAllUsers(Director $director, Game $game, array $dayMoves, int $roundCounter)
    {
        foreach ($game->getAliveUsers() as $votingUser) {
            if (!$votingUser->canVote()) {
                continue;
            }

            if (!isset($dayMoves[$votingUser->getName()])) {
                continue;
            }

            $userAgainstName = $dayMoves[$votingUser->getName()];

            $director->askAboutVote($votingUser);

            $this->performVote($game, $votingUser, $userAgainstName, $roundCounter);
        }
    }

    /**
     * @param Game $game
     */
    public function resetUsers(Game $game)
    {
        foreach ($game->getUsers() as $user) {
            $user->init();
        }
    }

    /**
     * @param Director $director
     * @param Game $game
     */
    private function performTalkForAllUsers(Director $director, Game $game)
    {
        foreach ($game->getAliveUsers() as $talkingUser) {
            if (!$talkingUser->canTalk()) {
                continue;
            }

            $director->askAboutTalk($talkingUser);
            $talkingUser->talk();
        }
    }
}