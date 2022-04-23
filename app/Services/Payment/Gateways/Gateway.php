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

    abstract public function make_payment();

    abstract public function do_payment();

    abstract public function get_payment_url();

    abstract public function do_verify();

    abstract public function fetch_config();

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
