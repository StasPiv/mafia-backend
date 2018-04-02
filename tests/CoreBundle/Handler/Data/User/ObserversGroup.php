<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:32
 */

namespace CoreBundle\Tests\Handler\Data\User;


use CoreBundle\Tests\Handler\Data\AbstractNightUserGroup;
use CoreBundle\Tests\Handler\Data\ObserveAction;

class ObserversGroup extends AbstractNightUserGroup
{
    public function __construct()
    {
        parent::__construct();

        $this->nightActions->add(new ObserveAction());
        $this->nightUsers->add(new Dambldor());
    }

    function getName(): string
    {
        return 'Observers';
    }

    function getOrder(): int
    {
        return 3;
    }

}