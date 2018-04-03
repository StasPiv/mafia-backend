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
    public function process(Director $director, Game $game, GameAnalyzer $gameAnalyzer, array $moves = [])
    {
        $roundCounter = 0;

        do {
            foreach ($game->getUsers() as $user) {
                $user->init();
            }

            foreach ($game->getNightUserGroups() as $nightUserGroup) {
                $director->askAboutNightAction($nightUserGroup);

                if (!$nightUserGroup->isGroupAlive()) {
                    continue;
                }

                foreach ($nightUserGroup->getNightActions() as $action) {
                    /** @var Collection|User[] $destinationUsers */

                    $destinationUsers = $game->getAliveUsers()->filter(
                        function (User $user) use ($moves, $roundCounter, $nightUserGroup)
                        {
                            return in_array($user->getName(), $moves[$roundCounter]['night'][$nightUserGroup->getName()]);
                        }
                    );

                    $result = $action->execute($nightUserGroup, $destinationUsers);

                    echo $result . PHP_EOL;
                }
            }

            $gameAnalyzer->analyzeNight($game);

            foreach ($game->getAliveUsers() as $talkingUser) {
                if (!$talkingUser->canTalk()) {
                    continue;
                }

                echo $director->askAboutTalk($talkingUser) . PHP_EOL;
                $talkingUser->talk();
            }

            foreach ($game->getAliveUsers() as $votingUser) {
                if (!$votingUser->canVote()) {
                    continue;
                }

                if (!isset($moves[$roundCounter]['day'][$votingUser->getName()])) {
                    continue;
                }

                echo $director->askAboutVote($votingUser) . PHP_EOL;

                $nameAgainst = $moves[$roundCounter]['day'][$votingUser->getName()];
                /** @var User $userAgainst */
                $userAgainst = $game->getAliveUsers()->filter(
                    function (User $user) use ($votingUser, $roundCounter, $nameAgainst)
                    {
                        return $user->getName() === $nameAgainst;
                    }
                )->first();

                if (!$userAgainst) {
                    throw new \RuntimeException(sprintf('There is no alive user with name %s. Round: %d, Voting user: %s', $nameAgainst, $roundCounter, $votingUser->getName()));
                }

                $votingUser->vote($userAgainst);

                echo sprintf('User %s votes against user %s', $votingUser->getName(), $userAgainst->getName()) . PHP_EOL;
            }
            $roundCounter++;

            $gameAnalyzer->analyzeVote($game);
        } while (!$game->isFinished());
    }
}