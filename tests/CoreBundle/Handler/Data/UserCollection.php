<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 04.04.18
 * Time: 13:27
 */

namespace CoreBundle\Tests\Handler\Data;

use CoreBundle\Model\User;
use CoreBundle\Model\UserCollectionInterface;
use Doctrine\Common\Collections\ArrayCollection;

class UserCollection extends ArrayCollection implements UserCollectionInterface
{
    /**
     * @return string
     */
    function __toString()
    {
        return implode(', ', array_map(
            function (User $user)
            {
                return $user->getName();
            },
            $this->getValues()
        ));
    }

}