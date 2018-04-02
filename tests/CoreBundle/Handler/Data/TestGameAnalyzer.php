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

class TestGameAnalyzer implements GameAnalyzer
{
    /**
     * @param Game $game
     */
    function analyze(Game $game)
    {
        foreach ($game->getAliveUsers() as $aliveUser) {

            $visitorStatuses = [];

            foreach ($aliveUser->getNightVisitors() as $nightVisitor) {
                $visitorStatuses = array_merge($visitorStatuses, $nightVisitor->getStatuses()->getValues());
            }

            if (
                in_array(StatusEnum::KILLED, $aliveUser->getStatuses()->getValues()) &&
                !in_array(StatusEnum::REFLECTED, $visitorStatuses)
            ) {
                $aliveUser->die();
            }

            if (
                in_array(StatusEnum::TRIED_TO_KILL, $aliveUser->getStatuses()->getValues()) &&
                !in_array(StatusEnum::REFLECTED, $aliveUser->getStatuses()->getValues())
            ) {
                $aliveUser->die();
            }
        }

        if (empty($game->getAlivePeacefulUsers())) {
            $game->setFinished(true);
        }
    }

}