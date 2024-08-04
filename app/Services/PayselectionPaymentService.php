<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\DTO\PaymentDTO;
use Illuminate\Support\Facades\Auth;

class PayselectionPaymentService implements PaymentGateway
{
    public function __construct(
        private readonly array $credentials
    )
    {}

    public function getRequestSignature($method, $url, $siteId, $requestId, $body, $key): string
    {
        $signature_string = "{$method}\n{$url}\n{$siteId}\n{$requestId}\n{$body}";
        return hash_hmac('sha256', $signature_string, $key);
    }

    public function init(PaymentDTO $dto)
    {
        $request_id = time();

        $body = json_encode([
            'PaymentRequest' => [
                'OrderId' => (string) $request_id,
                'Amount' => config('app.price.amount'),
                'Currency' => config('app.price.currency'),
                'Description' => 'Subscription payment',
                'RebillFlag' => true,
                'ExtraData' => [
                    'ReturnUrl' => route('payment.return').'?order_id='.$request_id.'&user_id='.Auth::id(),
                ]
            ],
            'CustomerInfo' => [
                'Email' => Auth::user()->email,
                'ReceiptEmail' => Auth::user()->email,
                'Language' => 'ru',
            ],
            'RecurringData' => [
                'Amount' => config('app.price.amount'),
                'Currency' => config('app.price.currency'),
                'Description' => 'Subscription payment',
                'AccountId' => (string) Auth::id(),
                'Email' => Auth::user()->email,
                'Interval' => '1',
                'Period' => 'month'
            ]
        ]);

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://webform.payselection.com/webpayments/paylink_create',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'X-SITE-ID: ' . $this->credentials['x_site_id'],
                'X-REQUEST-ID: ' . $request_id,
                'X-REQUEST-SIGNATURE: ' . $this->getRequestSignature(
                    "POST",
                    "https://webform.payselection.com/webpayments/paylink_create",
                    $this->credentials['x_site_id'],
                    $request_id,
                    $body,
                    $this->credentials['public_key']
                )
            ],
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $body
        ]);

        $paymentObj = curl_exec($ch);
        curl_close($ch);

        $paymentObj = json_decode($paymentObj, true);

        return match (curl_getinfo($ch, CURLINFO_HTTP_CODE)) {
            201 => $paymentObj['Url'],
            default => throw new \Exception(message: $paymentObj['message'])
        };
    }

    public function confirm()
    {
        // TODO: Implement get_payment_status() method.
    }

    public function getStatus($orderId)
    {
        // TODO: Implement getStatus() method.
    }
}
