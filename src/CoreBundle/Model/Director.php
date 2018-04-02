<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:15
 */

namespace CoreBundle\Model;


interface Director
{
    public function askAboutNightAction(NightUserGroup $nightUserGroup);

    public function askAboutTalk(User $user);

    public function askAboutVote(User $user);
}