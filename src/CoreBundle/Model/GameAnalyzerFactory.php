<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:57
 */

namespace CoreBundle\Model;


interface GameAnalyzerFactory
{
    static function createAnalyzer(): GameAnalyzer;
}