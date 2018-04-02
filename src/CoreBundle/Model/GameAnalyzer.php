<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:56
 */

namespace CoreBundle\Model;


interface GameAnalyzer
{
    /**
     * @param Game $game
     */
    function analyze(Game $game);
}