<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\DTO\PaymentDTO;
use Exception;
use Illuminate\Support\Facades\Auth;

class EpayPaymentService implements PaymentGateway
{
    public function __construct(
        protected array $credentials
    )
    {}

    public function getToken($body): bool|string
    {
        $ch = curl_init($this->credentials['url']);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_POSTFIELDS => $body
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }
    public function createPaymentObject(): false|string
    {
        $invoiceId = time();

        Auth::user()->update(['invoice_id' => $invoiceId]);

        $body = [
            'grant_type' => 'client_credentials',
            'scope' => 'webapi usermanagement email_send verification statement statistics payment',
            'client_id' => $this->credentials['client_id'],
            'client_secret' => $this->credentials['client_secret'],
            'terminal' => $this->credentials['terminal_id'],
            'invoiceID' => $invoiceId,
            'amount' => config('app.price.amount'),
            'currency' => config('app.price.currency'),
            'postLink' => route('payment.return').'?invoiceID='.$invoiceId.'&user_id='.Auth::id()
        ];

        $token = json_decode($this->getToken($body));

        return json_encode([
            'invoiceId' => $invoiceId,
            'backLink' => route('payment.return').'?invoiceID='.$invoiceId.'&user_id='.Auth::id(),
            'failureBackLink' => route('payment.return').'?invoiceID='.$invoiceId.'&user_id='.Auth::id(),
            'postLink' => route('payment.return').'?invoiceID='.$invoiceId.'&user_id='.Auth::id(),
            'language' => 'rus',
            'description' => 'subscription payment',
            'terminal' => $this->credentials['terminal_id'],
            'amount' => config('app.price.amount'),
            'accountId'=> '1',
            'cardSave'=>true,
            'currency' => config('app.price.currency'),
            'auth' => $token
        ]);
    }
    public function init(PaymentDTO $dto)
    {}

    public function getStatus($orderId)
    {
        $body = [
            'grant_type' => 'client_credentials',
            'scope' => 'webapi usermanagement email_send verification statement statistics payment',
            'client_id' => $this->credentials['client_id'],
            'client_secret' => $this->credentials['client_secret'],
            'terminal' => $this->credentials['terminal_id']
        ];

        $token = json_decode($this->getToken($body));

        $ch = curl_init($this->credentials['url2'].'/'.$orderId);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.$token->access_token,
            ]
        ]);

        curl_close($ch);
        return json_decode(curl_exec($ch));
    }

    /**
     * @throws Exception
     */
    public function confirm()
    {
        $orderId = Auth::user()->invoice_id;
        $status = $this->getStatus($orderId);

        return match ($status->resultCode){
            100 => Auth::user()->update(['is_paid' => true]),
            default=>throw new Exception($status->resultMessage.' Transaction id: '.$status->transaction->id)
        };
    }
}
