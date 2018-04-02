<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:35
 */

namespace CoreBundle\Tests\Handler\Data;


use CoreBundle\Model\Game;
use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractTestGame implements Game
{
    /**
     * @var Collection|User[]
     */
    protected $users;

    /**
     * @var Collection|NightUserGroup[]
     */
    protected $nightUserGroups;

    /**
     * @var Collection|User[]
     */
    protected $aliveUsers;

    /**
     * @var bool
     */
    protected $finished = false;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->nightUserGroups = new ArrayCollection();
        $this->aliveUsers = new ArrayCollection();
    }

    function addUser(User $user): Game
    {
        $this->users->add($user);

        return $this;
    }

    function getUsers(): Collection
    {
        return $this->users;
    }

    function addNightUserGroup(NightUserGroup $nightUserGroup): Game
    {
        $this->nightUserGroups->add($nightUserGroup);

        foreach ($nightUserGroup->getNightUsers() as $nightUser) {
            $this->addAliveUser($nightUser);
        }

        return $this;
    }

    function getNightUserGroups(): Collection
    {
        return $this->nightUserGroups;
    }

    function addAliveUser(NightUser $nightUser): Game
    {
        $this->aliveUsers->add($nightUser);

        return $this;
    }

    function getAliveUsers(): Collection
    {
        return $this->aliveUsers;
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

    function getAlivePeacefulUsers(): Collection
    {
        $peacefulCitizens = new ArrayCollection();

        foreach ($this->getAliveUsers() as $user) {
            if ($user->isPeaceful()) {
                $peacefulCitizens->add($user);
            }
        }

        return $peacefulCitizens;
    }

}