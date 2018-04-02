<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:41
 */

namespace CoreBundle\Tests\Handler\Data\Game;

use CoreBundle\Tests\Handler\Data\AbstractTestGame;
use CoreBundle\Tests\Handler\Data\User\Mafia;
use CoreBundle\Tests\Handler\Data\User\ObserversGroup;
use CoreBundle\Tests\Handler\Data\User\PeacefulCitizen;
use CoreBundle\Tests\Handler\Data\User\ReflectorsGroup;

class TestGame extends AbstractTestGame
{
    public function __construct()
    {
        parent::__construct();

        $this->aliveUsers->add(new PeacefulCitizen('Some nick'));
        $this->aliveUsers->add(new PeacefulCitizen('Nick 2'));
        $this->aliveUsers->add(new PeacefulCitizen('Another nick'));

        $this->addNightUserGroup(new Mafia());
        $this->addNightUserGroup(new ReflectorsGroup());
        $this->addNightUserGroup(new ObserversGroup());
    }

}