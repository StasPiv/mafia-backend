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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractNightUserGroup implements NightUserGroup
{
    protected $name = '';

    /**
     * @var Collection|int[]
     */
    protected $statuses;

    /**
     * @var Collection|NightUser[]
     */
    protected $nightUsers;

    protected $nightActions;

    protected $destinationUsers;

    public function __construct()
    {
        $this->statuses = new ArrayCollection();

        $this->nightUsers = new ArrayCollection();

        foreach ($this->nightUsers as $nightUser) {
            $nightUser->setNightGroup($this);
        }

        $this->nightActions = new ArrayCollection();
        $this->destinationUsers = new ArrayCollection();
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


    function getNightUsers(): Collection
    {
        $values = $this->nightUsers->getValues();

        usort(
            $values,
            function (NightUser $userA, NightUser $userB) {
                return $userA->getOrder() <=> $userB->getOrder();
            }
        );

        $this->nightUsers = new ArrayCollection($values);

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

    function getDestinationUsers(): Collection
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

}