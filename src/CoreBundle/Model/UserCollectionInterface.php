<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 04.04.18
 * Time: 13:27
 */

namespace CoreBundle\Model;


use Doctrine\Common\Collections\Collection;

interface UserCollectionInterface extends Collection
{
    function __toString();
}