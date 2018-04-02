<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 14:52
 */

namespace CoreBundle\Model;

use Doctrine\Common\Collections\Collection;

interface User
{
    function isPeaceful(): bool;

    function getName(): string;

    function addStatus(int $status): self;

    /**
     * @return Collection|int[]
     */
    function getStatuses(): Collection;

    function addNightVisitor(NightUser $nightUser): self;

    /**
     * @return Collection|NightUser[]
     */
    function getNightVisitors(): Collection;

    function die(): bool;

    function talk(): bool;

    function vote(User $user): bool;

    function canTalk(): bool;

    function canVote(): bool;

    function isAlive(): bool;

    function isNight(): bool;

    function makeSleep(): bool;

    function isSleep(): bool;

    function getVotesAgainst(): int;

    function addVoteAgainst(int $number = 1): self;
}