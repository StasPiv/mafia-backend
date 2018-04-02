<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:23
 */

namespace CoreBundle\Model;


interface StatusEnum
{
    const NULL = 0;

    const KILLED = 1;

    const OBSERVED = 2;

    const REFLECTED = 3;

    const TRIED_TO_REFLECT = 4;

    const TRIED_TO_KILL = 5;
}