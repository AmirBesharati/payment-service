<?php

namespace App\Exceptions\Payment;


class GateWayNotFoundException extends \Exception
{
    public function __construct($message = "", $code = 0)
    {
        parent::__construct($message, $code);
    }
}
