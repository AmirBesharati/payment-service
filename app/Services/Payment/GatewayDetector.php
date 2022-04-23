<?php

namespace App\Services\Payment;

use App\Exceptions\Payment\GateWayNotFoundException;
use App\Services\Payment\Gateways\Behpardakht\Behpardakht;
use App\Services\Payment\Gateways\ZarinPal\ZarinPal;

class GatewayDetector
{
    protected $gateway_name;
    protected $invoice;


    const _GATEWAY_ZARINPAL = 'zarinpal';
    const _GATEWAY_SAMAN = 'samanpay';
    const _GATEWAY_BEHPARDAKHT = 'behpardakht';


    public function __construct($invoice , $gateway_name)
    {
        $this->invoice = $invoice;
        $this->gateway_name = $gateway_name;
    }

    /**
     * @throws GateWayNotFoundException
     */
    public function gateway()
    {
        switch ($this->gateway_name){
            case self::_GATEWAY_ZARINPAL:
                return new ZarinPal($this->invoice);
                break;

            case self::_GATEWAY_BEHPARDAKHT:
                return new Behpardakht($this->invoice);
                break;
        }
        throw new GateWayNotFoundException('Gateway Not found' , 400);
    }

}
