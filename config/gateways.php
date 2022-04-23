<?php


return [
    'default_gateway' => 'zarinpal',


    'zarinpal' => [
        'authority_url' => 'https://api.zarinpal.com/pg/v4/payment/request.json' ,
        'pay_url' => 'https://sandbox.zarinpal.com/pg/StartPay/' ,
        'merchant_id' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' ,
        'callback_url' => 'localhost:8000/verify'
    ] ,


    'behpardakht' => [
        'terminal_id' => 'xxxxx' ,
        'user_name' => 'xxxx' ,
        'password' => 'xxxx' ,
        'authority_url' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' ,
        'pay_url' => 'https://bpm.shaparak.ir/pgwchannel/startpay.mellat' ,
        'verify_url' => 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' ,


    ]
];
