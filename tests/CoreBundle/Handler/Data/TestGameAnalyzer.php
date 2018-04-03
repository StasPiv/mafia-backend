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
use CoreBundle\Model\StatusEnum;
use CoreBundle\Model\User;

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
                $aliveUser->die();
            }
        }

        if (empty($game->getAlivePeacefulUsers())) {
            $game->setFinished(true);
        } else {
            echo sprintf('Left %d alive peaceful users', $game->getAlivePeacefulUsers()->count());
        }
    }

    /**
     * @param Game $game
     * @return mixed
     */
    function analyzeVote(Game $game)
    {
        echo 'Analyze vote';
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

}