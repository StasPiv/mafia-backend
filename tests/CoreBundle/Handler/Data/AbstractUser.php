<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:57
 */

namespace CoreBundle\Tests\Handler\Data;


use CoreBundle\Model\NightUser;
use CoreBundle\Model\NightUserGroup;
use CoreBundle\Model\User;
use CoreBundle\Model\UserCollectionInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractUser implements User
{
    protected $name = '';

    /**
     * @var Collection|int[]
     */
    protected $statuses;

    /**
     * @var UserCollectionInterface|NightUser[]
     */
    protected $nightVisitors;

    /**
     * @var UserCollectionInterface|NightUser[]
     */
    protected $killers;

    protected $alive = true;

    protected $talk = true;

    protected $vote = true;

    protected $night = false;

    protected $sleep = false;

    protected $votesAgainst = 0;

    public function __construct()
    {
        $this->init();
    }

    public function init()
    {
        $this->statuses = new ArrayCollection();
        $this->nightVisitors = new UserCollection();
        $this->killers = new ArrayCollection();
        $this->votesAgainst = 0;
    }

    function addStatus(int $status): User
    {
        $this->statuses->add($status);

        return $this;
    }

    function getStatuses(): Collection
    {
        return $this->statuses;
    }

    /**
     * @param NightUser $nightUser
     * @return User
     */
    function addNightVisitor(NightUser $nightUser): User
    {
        $this->nightVisitors->add($nightUser);

        return $this;
    }

    /**
     * @return UserCollectionInterface|NightUser[]
     */
    function getNightVisitors(): UserCollectionInterface
    {
        return $this->nightVisitors;
    }

    /**
     * @param NightUser|NightUserGroup $nightUserGroup
     * @return User
     */
    function addKiller(NightUserGroup $nightUserGroup): User
    {
        $this->killers->add($nightUserGroup);

        return $this;
    }

    /**
     * @return Collection|NightUserGroup[]
     */
    function getKillers(): Collection
    {
        return $this->killers;
    }

    /**
     * @return bool
     */
    function die(): bool
    {
        $this->alive = false;

        echo sprintf('User "%s" died' . PHP_EOL, $this);

        return $this->alive;
    }

    function talk(): bool
    {
        //echo 'Bla bla bla bla' . PHP_EOL;
        return true;
    }

    function vote(User $user): bool
    {
        $user->addVoteAgainst();
        echo sprintf('User %s votes against user %s', $this->getName(), $user->getName()) . PHP_EOL;

        return true;
    }

    function canTalk(): bool
    {
        return $this->alive && $this->talk;
    }

    function canVote(): bool
    {
        return $this->alive && $this->vote;
    }

    function isAlive(): bool
    {
        return $this->alive;
    }

    function isNight(): bool
    {
        return false;
    }

    function makeSleep(): bool
    {
        $this->sleep = true;

        return $this->sleep;
    }

    function isSleep(): bool
    {
        return $this->sleep;
    }

    function getVotesAgainst(): int
    {
        return $this->votesAgainst;
    }

    function addVoteAgainst(int $number = 1): User
    {
        $this->votesAgainst += $number;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return AbstractUser
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    function __toString()
    {
        return $this->getName();
    }

}