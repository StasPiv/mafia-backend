<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:21
 */

namespace CoreBundle\Tests\Handler\Data\User;

use CoreBundle\Tests\Handler\Data\AbstractNightUserGroup;
use CoreBundle\Tests\Handler\Data\KillAction;

class Mafia extends AbstractNightUserGroup
{
    public function __construct()
    {
        parent::__construct();

        $this->nightActions->add(new KillAction());
        $this->nightUsers->add(new MafiaBoss());
        $this->nightUsers->add(new MafiaHelper());
    }

    function getName(): string
    {
        return 'Mafia';
    }

    function getOrder(): int
    {
        return 1;
    }

}