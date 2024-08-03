<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentGateway;
use App\DTO\PaymentDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mockery\Exception;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentGateway $payment
    )
    {}

    public function index()
    {
        return view('pages.pricing');
    }

    public function create(string $period)
    {
        try {
            $dto = new PaymentDTO(period: $period);
            $paymentLink = $this->payment->init($dto);
            return redirect($paymentLink);

        } catch (Exception $e)
        {
            return back()->with('error', $e->getMessage());
        }
    }

    public function confirm()
    {
        try {
            $this->payment->confirm();
            return redirect(route('profile.dashboard'))
                ->with(['success'=>'Thank you!']);

        } catch (\Exception $e) {
            return back()->withErrors([
                'message'=>$e->getMessage()
            ]);
        }
    }

    public function cancel()
    {
        return redirect(route('pricing'))
            ->withErrors(['message'=>'payment cancelled']);
    }
}
