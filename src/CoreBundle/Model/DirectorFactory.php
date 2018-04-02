<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:15
 */

namespace CoreBundle\Model;


interface DirectorFactory
{
    static function createDirector(): Director;
}