<x-guest-layout bodyClass="text-center">
    <main class="verify-email mt-5">
        <div class="container">
            @session('message')
                <x-alert type="success" :message="$value"></x-alert>
            @endsession

            <p class="alert alert-info">
                Click on the verification link sent to your email. <a href="{{route('verification.send')}}">Click here to resend email.</a>
            </p>
        </div>
    </main>
</x-guest-layout>
