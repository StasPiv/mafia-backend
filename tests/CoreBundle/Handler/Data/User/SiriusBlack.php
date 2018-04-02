<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:31
 */

namespace CoreBundle\Tests\Handler\Data\User;


use CoreBundle\Tests\Handler\Data\AbstractNightUser;

class SiriusBlack extends AbstractNightUser
{
    function getOrder(): int
    {
        return 1;
    }

    function getName(): string
    {
        return 'Sirius Black';
    }

    function isPeaceful(): bool
    {
        return true;
    }

}