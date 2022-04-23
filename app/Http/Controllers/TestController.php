<?php

namespace App\Http\Controllers;

use App\Services\Payment\GatewayDetector;
use App\Services\Payment\Invoice;
use App\Services\Payment\Payment;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        $invoice = new Invoice();
        $invoice->setAmount(1000);
        $invoice->setDescription('description');
        $invoice->setUserEmail('amirbesharati59@gmail.com');
        $invoice->setUserPhone('09129586758');

        $pay = new Payment($invoice);
        $pay->setGatewayName(GatewayDetector::_GATEWAY_ZARINPAL);
        $pay->do_payment();

    }
}
