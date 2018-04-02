<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 14:52
 */

namespace CoreBundle\Model;

use CoreBundle\Tests\Handler\Data\AbstractNightUser;

interface NightUser extends User
{
    /**
     * @return int
     */
    function getOrder(): int;

    /**
     * @return NightUserGroup
     */
    function getNightGroup(): NightUserGroup;

    /**
     * @param NightUserGroup $nightGroup
     * @return AbstractNightUser
     */
    public function setNightGroup(NightUserGroup $nightGroup): self;
}