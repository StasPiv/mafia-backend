<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:35
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\Game;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;
use CoreBundle\Model\UserCollectionInterface;
use CoreBundle\Tests\Handler\Data\Game\TestGame;
use Doctrine\Common\Collections\Collection;

abstract class AbstractTestGame implements Game
{
    /**
     * @var UserCollectionInterface|User[]
     */
    protected $users;

    /**
     * @var Collection|NightUserGroup[]
     */
    protected $nightUserGroups;

    /**
     * @var UserCollectionInterface|User[]
     */
    protected $aliveUsers;

    /**
     * @var bool
     */
    protected $finished = false;

    /**
     * @var bool
     */
    protected $mafiaWon = false;

    /**
     * @var bool
     */
    protected $cityWon = false;

    public function __construct()
    {
        $this->users = new UserCollection();
        $this->nightUserGroups = new UserCollection();
        $this->aliveUsers = new UserCollection();
    }

    function addUser(User $user): Game
    {
        $this->users->add($user);

        return $this;
    }

    function getUsers(): UserCollectionInterface
    {
        return $this->users;
    }

    function addNightUserGroup(NightUserGroup $nightUserGroup): Game
    {
        $this->nightUserGroups->add($nightUserGroup);

        foreach ($nightUserGroup->getNightUsers() as $nightUser) {
            $this->addUser($nightUser);
        }

        return $this;
    }

    function getNightUserGroups(): Collection
    {
        return $this->nightUserGroups;
    }

    function addAliveUser(User $nightUser): Game
    {
        $this->aliveUsers->add($nightUser);

        return $this;
    }

    function getAliveUsers(): UserCollectionInterface
    {
        $aliveUsers = new UserCollection();

        foreach ($this->users as $user) {
            if ($user->isAlive()) {
                $aliveUsers->add($user);
            }
        }

        return $this->aliveUsers = $aliveUsers;
    }

    function setFinished(bool $finished): bool
    {
        $this->finished = $finished;

        return $this->finished;
    }

    function isFinished(): bool
    {
        return $this->finished;
    }

    function getAlivePeacefulUsers(): UserCollectionInterface
    {
        $peacefulCitizens = new UserCollection();

        foreach ($this->getAliveUsers() as $user) {
            if ($user->isPeaceful()) {
                $peacefulCitizens->add($user);
            }
        }

        return $peacefulCitizens;
    }

    /**
     * @return bool
     */
    public function isMafiaWon(): bool
    {
        return $this->mafiaWon;
    }

    /**
     * @param bool $mafiaWon
     * @return Game
     */
    function setMafiaWon(bool $mafiaWon): Game
    {
        $this->mafiaWon = $mafiaWon;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCityWon(): bool
    {
        return $this->cityWon;
    }

    /**
     * @param bool $cityWon
     * @return Game
     */
    function setCityWon(bool $cityWon): Game
    {
        $this->cityWon = $cityWon;
        return $this;
    }

}