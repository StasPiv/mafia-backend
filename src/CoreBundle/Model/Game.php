<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 14:57
 */

namespace CoreBundle\Model;

use Doctrine\Common\Collections\Collection;

interface Game
{
    /**
     * @param User $user
     * @return Game
     */
    function addUser(User $user): Game;

    /**
     * @return Collection|User[]
     */
    function getUsers(): Collection;

    /**
     * @return Collection|NightUserGroup[]
     */
    function getNightUserGroups(): Collection;

    /**
     * @return Collection|NightUser[]
     */
    function getAliveUsers(): Collection;

    function setFinished(bool $finished): bool;

    /**
     * @return bool
     */
    function isFinished(): bool;

    /**
     * @return Collection|User[]
     */
    function getAlivePeacefulUsers(): Collection;
}