<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 14:53
 */

namespace CoreBundle\Model;


use Doctrine\Common\Collections\Collection;

interface NightAction
{
    /**
     * @param NightUserGroup $source
     * @param UserCollectionInterface|User[] $destination
     * @return Result
     */
    function execute(NightUserGroup $source, UserCollectionInterface $destination): Result;
}