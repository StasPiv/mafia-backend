<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:46
 */

namespace CoreBundle\Tests\Handler\Data\Director;

use CoreBundle\Model\Director;
use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;

class TestDirector implements Director
{
    public function askAboutNightAction(NightUserGroup $nightUserGroup)
    {
        return sprintf('Wake up %s which contains %s', $nightUserGroup->getName(),
            implode(
                ',',
                array_map(
                    function (NightUser $user)
                    {
                        return $user->getName();
                    },
                    $nightUserGroup->getNightUsers()->getValues()
                )
            )
        );
    }

    public function askAboutTalk(User $user)
    {
        echo sprintf('Please say dear %s', $user->getName()) . PHP_EOL;
        return true;
    }

    public function askAboutVote(User $user)
    {
        echo sprintf('Please vote dear %s' . PHP_EOL, $user->getName());
        return true;
    }

}