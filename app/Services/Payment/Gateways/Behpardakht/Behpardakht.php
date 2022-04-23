<?php

namespace App\Services\Payment\Gateways\Behpardakht;

use App\Services\Payment\Gateways\Gateway;
use Illuminate\Support\Facades\Config;

class Behpardakht extends Gateway
{


    protected $config;
    protected $invoice;

    public function make_payment()
    {
        // TODO: Implement make_payment() method.
    }

    public function do_payment()
    {
        // TODO: Implement do_payment() method.
    }

    public function get_payment_url()
    {
        // TODO: Implement get_payment_url() method.
    }

    public function do_verify()
    {
        // TODO: Implement do_verify() method.
    }

    public function fetch_config()
    {
        // TODO: Implement fetch_config() method.
        $this->config = Config::get('gateways.behpardakht');

    }

    protected function getStatusMessageByCode($status_code): string
    {
        $messages = [
            0 => 'تراكنش با موفقيت انجام شد',
            11 => 'شماره كارت نامعتبر است',
            12 => 'موجودي كافي نيست',
            13 => 'رمز نادرست است',
            14 => 'تعداد دفعات وارد كردن رمز بيش از حد مجاز است',
            15 => 'كارت نامعتبر است',
            16 => 'دفعات برداشت وجه بيش از حد مجاز است',
            17 => 'كاربر از انجام تراكنش منصرف شده است',
            18 => 'تاريخ انقضاي كارت گذشته است',
            19 => 'مبلغ برداشت وجه بيش از حد مجاز است',
            111 => 'صادر كننده كارت نامعتبر است',
            112 => 'خطاي سوييچ صادر كننده كارت',
            113 => 'پاسخي از صادر كننده كارت دريافت نشد',
            114 => 'دارنده كارت مجاز به انجام اين تراكنش نيست',
            21 => 'پذيرنده نامعتبر است',
            23 => 'خطاي امنيتي رخ داده است',
            24 => 'اطلاعات كاربري پذيرنده نامعتبر است',
            25 => 'مبلغ نامعتبر است',
            31 => 'پاسخ نامعتبر است',
            32 => 'فرمت اطلاعات وارد شده صحيح نمي باشد',
            33 => 'حساب نامعتبر است',
            34 => 'خطاي سيستمي',
            35 => 'تاريخ نامعتبر است',
            41 => 'شماره درخواست تكراري است',
            42 => 'تراكنش Sale يافت نشد',
            43 => 'قبلا درخواست Verify داده شده است',
            44 => 'درخواست Verfiy يافت نشد',
            45 => 'تراكنش Settle شده است',
            46 => 'تراكنش Settle نشده است',
            47 => 'تراكنش Settle يافت نشد',
            48 => 'تراكنش Reverse شده است',
            49 => 'تراكنش Refund يافت نشد',
            412 => 'شناسه قبض نادرست است',
            413 => 'شناسه پرداخت نادرست است',
            414 => 'سازمان صادر كننده قبض نامعتبر است',
            415 => 'زمان جلسه كاري به پايان رسيده است',
            416 => 'خطا در ثبت اطلاعات',
            417 => 'شناسه پرداخت كننده نامعتبر است',
            418 => 'اشكال در تعريف اطلاعات مشتري',
            419 => 'تعداد دفعات ورود اطلاعات از حد مجاز گذشته است',
            421 => 'IPنامعتبر است',
            51 => 'تراكنش تكراري است',
            54 => 'تراكنش مرجع موجود نيست',
            55 => 'تراكنش نامعتبر است',
            61 => 'خطا در واريز',
        ];

        $message = 'خطایی رخ داده است.';

        if (array_key_exists($status_code, $messages)) {
            return $messages[$status_code];
        }
        return $message;
    }
}
