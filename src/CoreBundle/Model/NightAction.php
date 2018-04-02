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
     * @param Collection|NightUserGroup[] $source
     * @param Collection|NightUser[] $destination
     * @return Result
     */
    function execute(Collection $source, Collection $destination): Result;
}