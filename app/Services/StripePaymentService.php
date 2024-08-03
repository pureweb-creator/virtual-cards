<?php

namespace App\Services;

use App\Contracts\PaymentGateway;
use App\DTO\PaymentDTO;
use Illuminate\Support\Facades\Auth;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\Checkout\Session;

readonly class StripePaymentService implements PaymentGateway
{
    public function __construct(
        private array $credentials
    )
    {
        Stripe::setApiKey($this->credentials['secret_key']);
    }

    /**
     * @throws ApiErrorException
     */
    public function init(PaymentDTO $dto)
    {
        $priceId = match ($dto->period){
            'monthly'=>$this->credentials['monthly_price_id'],
            default=>$this->credentials['annual_price_id']
        };

        $checkout_session = Session::create([
            'line_items' => [[
                'price' => $priceId,
                'quantity' => 1,
            ]],
            'mode' => 'subscription',
            'success_url' => route('payment.return.success').'?period='.$dto->period,
            'cancel_url' => route('payment.return.cancel'),
        ]);

        Auth::user()->update([
            'invoice_id'=>$checkout_session->id
        ]);

        return $checkout_session->url;
    }

    public function getStatus($orderId)
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * @throws ApiErrorException
     * @throws \Exception
     */
    public function confirm(): void
    {
        $sessionId = Auth::user()->invoice_id;

        if (is_null($sessionId)){
            throw new \Exception('Invoice not found or already paid');
        }

        $session = Session::retrieve($sessionId);

        if ($session->status !== 'complete') {
            throw new \Exception('Payment failed');
        }

        $expTime = match(request()->query('period')){
            'monthly'=>now()->addMonth(),
            'annual'=>now()->addYear()
        };

        Auth::user()->update([
            'is_paid' => true,
            'expiration_time'=>$expTime,
            'invoice_id' => null
        ]);
    }
}
