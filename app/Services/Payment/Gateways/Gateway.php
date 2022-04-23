<?php

namespace App\Services\Payment\Gateways;


use App\Services\Payment\Invoice;

abstract class Gateway
{
    protected $config;
    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->fetch_config();
        $this->invoice = $invoice;
    }

    /**
     * Authorize payment with bank webservice
     */
    abstract public function make_payment();

    /**
     * fetch authorized detail within invoice and redirect user to payment url
     */
    abstract public function do_payment();

    /**
     * fetch authorized detail within invoice and return payment url
     */
    abstract public function get_payment_url();

    /**
     * Verify payment within Authority details
     */
    abstract public function do_verify();

    /**
     * fetch gateway config with corresponding config in gateways.php config file
     */
    abstract public function fetch_config();

    /**
     * get responded status message by status code
     */
    abstract protected function getStatusMessageByCode($status_code);


    public function setInvoice(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function getInvoice() : Invoice
    {
        return $this->invoice;
    }

}
