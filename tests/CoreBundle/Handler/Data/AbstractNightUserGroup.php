<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:16
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use CoreBundle\Model\UserCollectionInterface;

abstract class AbstractNightUserGroup implements NightUserGroup
{
    protected $name = '';

    /**
     * @var Collection|int[]
     */
    protected $statuses;

    /**
     * @var UserCollectionInterface|NightUser[]
     */
    protected $nightUsers;

    protected $nightActions;

    /**
     * @var UserCollectionInterface|User[]
     */
    protected $destinationUsers;

    public function __construct()
    {
        $this->statuses = new ArrayCollection();

        $this->nightUsers = new UserCollection();

        $this->initNightUsersByGroup();

        $this->nightActions = new ArrayCollection();
        $this->destinationUsers = new UserCollection();
    }

    function addStatus(int $status): NightUserGroup
    {
        $this->statuses->add($status);

        return $this;
    }

    function getStatuses(): Collection
    {
        return $this->statuses;
    }


    function getNightUsers(): UserCollectionInterface
    {
        $values = $this->nightUsers->getValues();

        usort(
            $values,
            function (NightUser $userA, NightUser $userB) {
                return $userA->getOrder() <=> $userB->getOrder();
            }
        );

        $this->nightUsers = new UserCollection($values);

        return $this->nightUsers;
    }

    function isGroupAlive(): bool
    {
        foreach ($this->getNightUsers() as $nightUser) {
            if ($nightUser->isAlive()) {
                return true;
            }
        }

        return false;
    }

    function getNightActions(): Collection
    {
        return $this->nightActions;
    }

    function getDestinationUsers(): UserCollectionInterface
    {
        return $this->destinationUsers;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    function __toString()
    {
        return sprintf(
            '%s (%s)',
            $this->getName(),
            $this->getNightUsers()
        );
    }

    /**
     * @param User $user
     * @return bool
     */
    function isUserExist(User $user): bool
    {
        return !$this->getNightUsers()->filter(
            function (User $nightUser) use ($user)
            {
                return $nightUser === $user;
            }
        )->isEmpty();
    }

    protected function initNightUsersByGroup()
    {
        foreach ($this->nightUsers as $nightUser) {
            $nightUser->setNightGroup($this);
        }
    }

}