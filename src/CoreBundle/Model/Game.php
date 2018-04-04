<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 14:57
 */

namespace CoreBundle\Model;

use CoreBundle\Tests\Handler\Data\UserCollection;
use Doctrine\Common\Collections\Collection;

interface Game
{
    /**
     * @param User $user
     * @return Game
     */
    function addUser(User $user): Game;

    /**
     * @return UserCollectionInterface|User[]
     */
    function getUsers(): UserCollectionInterface;

    /**
     * @return Collection|NightUserGroup[]
     */
    function getNightUserGroups(): Collection;

    /**
     * @return UserCollectionInterface|NightUser[]
     */
    function getAliveUsers(): UserCollectionInterface;

    function setFinished(bool $finished): bool;

    /**
     * @return bool
     */
    function isFinished(): bool;

    function setMafiaWon(bool $mafiaWon): self;

    /**
     * @return bool
     */
    function isMafiaWon(): bool;

    function setCityWon(bool $cityWon): self ;

    /**
     * @return bool
     */
    function isCityWon(): bool;

    /**
     * @return UserCollectionInterface|User[]
     */
    function getAlivePeacefulUsers(): UserCollectionInterface;
}