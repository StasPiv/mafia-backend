<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:21
 */

namespace CoreBundle\Tests\Handler\Data\User;

use CoreBundle\Tests\Handler\Data\AbstractNightUser;

class MafiaBoss extends AbstractNightUser
{
    protected $name = 'Mafia boss';

    function isPeaceful(): bool
    {
        return false;
    }

    function getOrder(): int
    {
        return 1;
    }

}