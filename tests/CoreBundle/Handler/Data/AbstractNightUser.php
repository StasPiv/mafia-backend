<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:10
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;

abstract class AbstractNightUser extends AbstractUser implements NightUser
{
    /**
     * @var NightUserGroup
     */
    protected $nightGroup;

    function isNight(): bool
    {
        return true;
    }

    /**
     * @return NightUserGroup
     */
    public function getNightGroup(): NightUserGroup
    {
        return $this->nightGroup;
    }

    /**
     * @param NightUserGroup $nightGroup
     * @return AbstractNightUser
     */
    public function setNightGroup(NightUserGroup $nightGroup): NightUser
    {
        $this->nightGroup = $nightGroup;
        return $this;
    }
}