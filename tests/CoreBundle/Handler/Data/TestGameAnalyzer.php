<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:41
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\Game;
use CoreBundle\Model\GameAnalyzer;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\StatusEnum;
use CoreBundle\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use function foo\func;

class TestGameAnalyzer implements GameAnalyzer
{
    /**
     * @param Game $game
     */
    function analyzeNight(Game $game)
    {
        foreach ($game->getAliveUsers() as $aliveUser) {
            if (
                $this->checkStatus($aliveUser, StatusEnum::KILLED)
            ) {
                $keepAlive = 0;
                foreach ($aliveUser->getKillers() as $killer) {
                    if (
                        $this->checkNightGroupStatus($killer,StatusEnum::REFLECTED) ||
                        $this->checkNightGroupStatus($killer, StatusEnum::BLOCKED)
                    ) {
                        $keepAlive++;
                    }
                }

                if ($keepAlive < $aliveUser->getKillers()->count()) {
                    $aliveUser->die();
                }
            }

            if (
                $this->checkStatus($aliveUser, StatusEnum::SHOTTED) &&
                $this->checkStatus($aliveUser, StatusEnum::REFLECTED)
            ) {
                $aliveUser->die();
            }
        }

        echo sprintf('Left %d alive peaceful users: %s and %s alive users: %s' . PHP_EOL, $game->getAlivePeacefulUsers()->count(), $game->getAlivePeacefulUsers(), $game->getAliveUsers()->count(), $game->getAliveUsers());

        if ($game->getAlivePeacefulUsers()->isEmpty()) {
            $game->setFinished(true);
            $game->setMafiaWon(true);
            echo sprintf(
                'Mafia won. Game is finished. Left users: %s' . PHP_EOL,
                $game->getAliveUsers()
            );
        }
    }

    /**
     * @param Game $game
     * @return mixed
     */
    function analyzeDay(Game $game)
    {
        echo 'Analyze vote' . PHP_EOL;

        /** @var User[] $aliveUsers */
        $aliveUsers = $game->getAliveUsers()->getValues();

        usort(
            $aliveUsers,
            function (User $userA, User $userB)
            {
                return $userB->getVotesAgainst() <=> $userA->getVotesAgainst();
            }
        );

        $maxVotesAgainst = $aliveUsers[0]->getVotesAgainst();

        if ($maxVotesAgainst === 0) {
            return;
        }

        $candidatesToDie = new ArrayCollection();

        foreach ($aliveUsers as $aliveUser) {
            if ($aliveUser->getVotesAgainst() === $maxVotesAgainst) {
                $candidatesToDie->add($aliveUser);
            }
        }

        if ($candidatesToDie->count() === 1) {
            /** @var User $singleCandidateToDie */
            $singleCandidateToDie = $candidatesToDie->first();
            $singleCandidateToDie->die();
        } else {
            // TODO: some strategy for revoting
        }

        if ($game->getAliveUsers()->count() === $game->getAlivePeacefulUsers()->count()) {
            $game->setFinished(true);
            $game->setCityWon(true);
            echo sprintf(
                'City won. Game is finished. Left users: %s' . PHP_EOL,
                $game->getAliveUsers()
            );
        }

        echo sprintf('Left %d alive peaceful users: %s and %d alive users: %s' . PHP_EOL, $game->getAlivePeacefulUsers()->count(), $game->getAlivePeacefulUsers(), $game->getAliveUsers()->count(), $game->getAliveUsers());
    }

    /**
     * @param User $aliveUser
     * @param int $status
     * @return bool
     */
    private function checkStatus(User $aliveUser, int $status): bool
    {
        return in_array($status, $aliveUser->getStatuses()->getValues());
    }

    /**
     * @param NightUserGroup $nightUserGroup
     * @param int $status
     * @return bool
     */
    private function checkNightGroupStatus(NightUserGroup $nightUserGroup, int $status): bool
    {
        return in_array($status, $nightUserGroup->getStatuses()->getValues());
    }

}