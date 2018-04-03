<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:57
 */

namespace CoreBundle\Tests\Handler\Data;


use CoreBundle\Model\NightUser;
use CoreBundle\Model\User;
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
     * @var Collection|NightUser[]
     */
    protected $nightVisitors;

    /**
     * @var Collection|NightUser[]
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
        $this->nightVisitors = new ArrayCollection();
        $this->killers = new ArrayCollection();
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
     * @return Collection|NightUser[]
     */
    function getNightVisitors(): Collection
    {
        return $this->nightVisitors;
    }

    /**
     * @param NightUser $nightUser
     * @return User
     */
    function addKiller(NightUser $nightUser): User
    {
        $this->killers->add($nightUser);

        return $this;
    }

    /**
     * @return Collection|NightUser[]
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

}