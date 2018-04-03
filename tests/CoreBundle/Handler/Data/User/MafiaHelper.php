<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:22
 */

namespace CoreBundle\Tests\Handler\Data\User;

use CoreBundle\Tests\Handler\Data\AbstractNightUser;

class MafiaHelper extends AbstractNightUser
{
    protected $name = 'Mafia helper';

    function isPeaceful(): bool
    {
        return false;
    }

    function getOrder(): int
    {
        return 2;
    }

}