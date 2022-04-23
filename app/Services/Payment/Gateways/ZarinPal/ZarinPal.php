<?php

namespace App\Services\Payment\Gateways\ZarinPal;

use App\Exceptions\Payment\MakePaymentFailedException;
use App\Exceptions\Payment\PaymentRequestFailedException;
use App\Services\Payment\Gateways\Gateway;
use App\Services\Payment\Invoice;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class ZarinPal extends Gateway
{
    /**
     * @var mixed
     */
    protected $config;
    protected $invoice;


    public function __construct(Invoice $invoice)
    {
        $this->fetch_config();
        $this->invoice = $invoice;
    }

    /**
     * @throws MakePaymentFailedException
     * @throws PaymentRequestFailedException
     */
    public function make_payment()
    {
        // TODO: Implement make_payment() method.
        $response = $this->do_request($this->getAuthorityUrl(), $this->getData());

        if (isset($response['errors']['code'])) {
            $code = $response['errors']['code'];
            $message = $this->getStatusMessageByCode($code);

            throw new MakePaymentFailedException($message, $code);
        }

        if (empty($response['data']['authority']) || (int) $response['data']['code'] !== 100) {
            $code = $response['errors']['code'];
            $message = $this->getStatusMessageByCode($response['data']['code']);


            throw new MakePaymentFailedException($message , $code );
        }

        $this->getInvoice()->setAuthority($response['data']['authority']);
    }

    public function get_payment_url(): string
    {
        // TODO: Implement do_payment() method.
        $authority = $this->getInvoice()->getAuthority();
        $paymentUrl = $this->getPaymentUrl();


        return $paymentUrl.'/'.$authority;
    }

    public function do_payment()
    {
        $url = $this->get_payment_url();

        return redirect($url);
    }

    public function do_verify()
    {
        // TODO: Implement do_verify() method.
    }

    public function fetch_config()
    {
        // TODO: Implement fetch_config() method.

        $this->config = Config::get('gateways.zarinpal');
    }

    private function getAuthorityUrl()
    {
        return $this->config['authority_url'];
    }

    private function getCallBackUrl()
    {
        return $this->config['callback_url'];
    }

    private function getMerchantId()
    {
        return $this->config['merchant_id'];
    }

    private function getPaymentUrl(){
        return $this->config['pay_url'];
    }

    private function getData(): array
    {
        $description = '';
        $user_phone = '';
        $user_email = '';


        if (!is_null($this->getInvoice()->getDescription())) {
            $description = $this->getInvoice()->getDescription();
        }
        if (!is_null($this->getInvoice()->getUserPhone())) {
            $user_phone = $this->getInvoice()->getUserPhone();
        }
        if (!is_null($this->getInvoice()->getUserEmail())) {
            $user_email = $this->getInvoice()->getUserEmail();
        }

        return [
            'merchant_id' => $this->getMerchantId(),
            'amount' => $this->getInvoice()->getAmount(),
            'callback_url' => $this->getCallbackUrl(),
            'description' => $description,
            'meta_data' => [
                'mobile' => $user_phone,
                'email' => $user_email
            ]
        ];
    }

    private function do_request(string $url, array $data, ?string $authorizationToken = null)
    {


        $http = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json'
        ]);


        /*if (!is_null($authorizationToken)) {
            $http = $http->withToken($authorizationToken);
        }*/

        $response = $http->post($url, $data);



        $responseArray = $response->json();



        if (isset($responseArray['data']['code']) || isset($responseArray['errors']['code'])) {
            return $responseArray;
        }

        throw new PaymentRequestFailedException($response->body(), $response->status());
    }

    protected function getStatusMessageByCode($status_code): string
    {
        $messages = [
            -9 => "خطای اعتبار سنجی",
            -10 => "آی پی یا مرچنت کد صحیح نیست.",
            -11 => "مرچنت کد فعال نیست.",
            -12 => "تلاش بیش از حد در یک بازه زمانی کوتاه",
            -15 => "ترمینال شما به حالت تعلیق درآمده است.",
            -16 => "سطح تایید پذیرنده پایین تر از سطح نقره ای است.",
            -30 => "اجازه دسترسی به تسویه اشتراکی شناور ندارید.",
            -31 => "حساب بانکی تسویه را به پنل اضافه کنید، مقادیر وارد شده برای تسهیم صحیح نیست.",
            -32 => "مجموع درصدهای تسهیم از سقف مجاز فراتر رفته است.",
            -33 => "درصدهای وارد شده صحیح نیست.",
            -34 => "مبلغ از کل تراکنش بالاتر است.",
            -35 => "تعداد افراد دریافت کننده تسهیم بیش از حد مجاز است.",
            -40 => "خطا در اطلاعات ورودی",
            -50 => "مقدار پرداخت شده با مبلغ وریفای متفاوت است.",
            -51 => "پرداخت ناموفق",
            -52 => "خطای غیرمنتظره، با پشتیبانی در تماس باشید.",
            -53 => "اتوریتی برای این مرچنت نیست.",
            -54 => "اتوریتی نامعتبر",
            100 => "عملیات موفق",
            101 => "تراکنش قبلا وریفای شده است.",
        ];

        $message = 'خطایی رخ داده است.';

        if(array_key_exists($status_code , $messages)){
            return $messages[$status_code];
        }
        return $message;
    }
}
