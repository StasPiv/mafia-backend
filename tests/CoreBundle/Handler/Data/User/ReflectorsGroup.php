<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:28
 */

namespace CoreBundle\Tests\Handler\Data\User;


use CoreBundle\Tests\Handler\Data\AbstractNightUserGroup;
use CoreBundle\Tests\Handler\Data\ReflectAction;

class ReflectorsGroup extends AbstractNightUserGroup
{
    protected $name = 'Reflectors';

    /**
     * ReflectorsGroup constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->nightActions->add(new ReflectAction());
        $this->nightUsers->add(new SiriusBlack());

        $this->initNightUsersByGroup();
    }

    function getOrder(): int
    {
        return 2;
    }

}