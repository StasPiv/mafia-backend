<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:07
 */

namespace CoreBundle\Model;


interface GameFactory
{
    static function createGame(): Game;
}