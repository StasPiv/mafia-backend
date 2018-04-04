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
    function addStatus(int $status): self;

    /**
     * @return Collection|int[]
     */
    function getStatuses(): Collection;

    /**
     * @return string
     */
    function getName(): string;

    /**
     * @return UserCollectionInterface|NightUser[]
     */
    function getNightUsers(): UserCollectionInterface;

    /**
     * @return bool
     */
    function isGroupAlive(): bool;

    /**
     * @return Collection|NightAction[]
     */
    function getNightActions(): Collection;

    /**
     * @return UserCollectionInterface|User[]
     */
    function getDestinationUsers(): UserCollectionInterface;

    /**
     * @return int
     */
    function getOrder(): int;

    function __toString();

    function isUserExist(User $user): bool;
}