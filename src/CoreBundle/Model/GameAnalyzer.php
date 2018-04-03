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
    function analyzeNight(Game $game);

    /**
     * @param Game $game
     */
    function analyzeVote(Game $game);
}