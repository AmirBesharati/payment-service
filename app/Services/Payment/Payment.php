<?php

namespace App\Services\Payment;

use App\Services\Payment\Gateways\Gateway;
use Illuminate\Support\Facades\Http;
use Omalizadeh\MultiPayment\Drivers\Contracts\PurchaseInterface;
use Omalizadeh\MultiPayment\Exceptions\InvalidConfigurationException;

class Payment
{
    protected $gateway_name = null;
    protected $invoice;
    /** @var Gateway $gateway*/
    protected $gateway = null;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * @return Invoice
     */
    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    /**
     * @param string $gateway_name
     */
    public function setGatewayName(string $gateway_name): void
    {
        $this->gateway_name = $gateway_name;
    }

    /**
     * @return mixed
     */
    public function getGatewayName()
    {
        if($this->gateway_name == null){
            return config('gateways.default_gateway');
        }
        return $this->gateway_name;
    }


    /**
     * @return Gateway|null
     */
    public function getGateway(): ?Gateway
    {
        return $this->gateway;
    }

    /**
     * @description : responsibility of this function is to call GatewayDetector to initialize selected Gateway class by Gateway name
     * @throws \App\Exceptions\Payment\GateWayNotFoundException
     */
    private function fetch_gateway_class()
    {
        $gateway_detector = new GatewayDetector($this->invoice , $this->getGatewayName());
        $this->gateway = $gateway_detector->gateway();
    }

    /**
     * @description : responsibility of this calss is to call essential payment methods and redirect user to payment page by do_payment method
     * @throws \App\Exceptions\Payment\GateWayNotFoundException
     */
    public function do_payment($callback = null)
    {
        //fetch gateway config
        $this->fetch_gateway_class();


        //get transaction id
        $transactionId = $this->getGateway()->make_payment();


        //call callback function if callback exists
        if ($callback) {
            $callback($transactionId);
        }

        //do payment
        return $this->getGateway()->do_payment();
    }


}
