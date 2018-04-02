<?php
/**
 * Created by mafia-backend.
 * User: ssp
 * Date: 02.04.18
 * Time: 16:28
 */

namespace CoreBundle\Model;


class SimpleResult implements Result
{
    /**
     * @var string
     */
    private $resultString;

    /**
     * SimpleResult constructor.
     * @param string $resultString
     */
    public function __construct($resultString)
    {
        $this->resultString = $resultString;
    }

    function __toString()
    {
        return $this->resultString;
    }
}