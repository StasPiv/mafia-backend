<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 15:23
 */

namespace CoreBundle\Model;


use Doctrine\Common\Collections\Collection;

interface NightUserGroup
{
    /**
     * @return string
     */
    function getName(): string;

    /**
     * @return Collection|NightUser[]
     */
    function getNightUsers(): Collection;

    /**
     * @return bool
     */
    function isGroupAlive(): bool;

    /**
     * @return Collection|NightAction[]
     */
    function getNightActions(): Collection;

    /**
     * @return Collection|User[]
     */
    function getDestinationUsers(): Collection;

    /**
     * @return int
     */
    function getOrder(): int;
}