<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 03.04.18
 * Time: 19:19
 */

namespace CoreBundle\Tests\Handler\Data\Director;


use CoreBundle\Model\Director;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;

class SilentDirector implements Director
{
    /**
     * @param NightUserGroup $nightUserGroup
     * @return mixed
     */
    public function askAboutNightAction(NightUserGroup $nightUserGroup)
    {
        return sprintf('Wake up %s', $nightUserGroup->getName());
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function askAboutTalk(User $user)
    {
        return '';
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function askAboutVote(User $user)
    {
        return '';
    }

}