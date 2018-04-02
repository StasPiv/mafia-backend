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
    public function process(Director $director, Game $game, GameAnalyzer $gameAnalyzer, array $moves = [])
    {
        $nightCounter = 0;
        $dayCounter = 0;

        do {
            $nightUserGroupCounter = 0;
            foreach ($game->getNightUserGroups() as $nightUserGroup) {
                $director->askAboutNightAction($nightUserGroup);

                if (!$nightUserGroup->isGroupAlive()) {
                    continue;
                }

                foreach ($nightUserGroup->getNightActions() as $action) {
                    /** @var Collection|User[] $destinationUsers */

                    $destinationUsers = $game->getAliveUsers()->filter(
                        function (User $user) use ($moves, $nightCounter, $nightUserGroupCounter)
                        {
                            return in_array($user->getName(), $moves['night'][$nightCounter][$nightUserGroupCounter]);
                        }
                    );

                    $result = $action->execute($nightUserGroup->getNightUsers(), $destinationUsers);

                    echo $result . PHP_EOL;
                }

                $nightUserGroupCounter++;
            }

            $nightCounter++;

            $gameAnalyzer->analyze($game);

            foreach ($game->getAliveUsers() as $aliveUser) {
                if (!$aliveUser->canTalk()) {
                    continue;
                }

                echo $director->askAboutTalk($aliveUser) . PHP_EOL;
                $aliveUser->talk();
            }

            foreach ($game->getAliveUsers() as $aliveUser) {
                if (!$aliveUser->canVote()) {
                    continue;
                }

                echo $director->askAboutVote($aliveUser) . PHP_EOL;

                /** @var User $userAgainst */
                $userAgainst = $game->getAliveUsers()->filter(
                    function (User $user) use ($moves, $dayCounter)
                    {
                        return in_array($user->getName(), $moves['day'][$dayCounter]);
                    }
                )->first();

                $dayCounter++;

                $aliveUser->vote($userAgainst);

                echo sprintf('User %s votes against user %s', $aliveUser->getName(), $userAgainst->getName()) . PHP_EOL;
            }

            $gameAnalyzer->analyze($game);
        } while (!$game->isFinished() && $nightCounter < 4 && $dayCounter < 4);
    }
}