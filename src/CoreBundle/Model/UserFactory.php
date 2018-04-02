<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:03
 */

namespace CoreBundle\Model;


interface UserFactory
{
    /**
     * @return User
     */
    static function createUser(): User;
}