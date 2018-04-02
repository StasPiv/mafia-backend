<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:27
 */

namespace CoreBundle\Model;

class NullResult implements Result
{
    /**
     * @return string
     */
    function __toString()
    {
        return 'Nothing';
    }

}