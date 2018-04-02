<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 17:20
 */

namespace CoreBundle\Tests\Handler\Data\User;

use CoreBundle\Tests\Handler\Data\AbstractUser;

class PeacefulCitizen extends AbstractUser
{
    protected $name = '';

    /**
     * PeacefulCitizen constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct();

        $this->name = $name;
    }

    function getName(): string
    {
        return $this->name;
    }

    function isPeaceful(): bool
    {
        return true;
    }
}