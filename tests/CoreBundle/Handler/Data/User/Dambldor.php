<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:33
 */

namespace CoreBundle\Tests\Handler\Data\User;

use CoreBundle\Tests\Handler\Data\AbstractNightUser;

class Dambldor extends AbstractNightUser
{
    protected $name = 'Dambldor';

    function isPeaceful(): bool
    {
        return true;
    }

    function getOrder(): int
    {
        return 1;
    }

}