<x-guest-layout bodyClass="text-center">
    <!-- Custom styles for this template -->
    <x-slot:style>
        <style>
            .bd-placeholder-img {
                font-size: 1.125rem;
                text-anchor: middle;
                -webkit-user-select: none;
                -moz-user-select: none;
                user-select: none;
            }

            @media (min-width: 768px) {
                .bd-placeholder-img-lg {
                    font-size: 3.5rem;
                }
            }

            html,
            body {
                height: 100%;
            }

            body {
                display: flex;
                align-items: center;
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #f5f5f5;
            }

            .form-signin {
                width: 100%;
                max-width: 330px;
                padding: 15px;
                margin: auto;
            }

            .form-signin .checkbox {
                font-weight: 400;
            }

            .form-signin .form-floating:focus-within {
                z-index: 2;
            }

            .form-signin input[name="email"],
            .form-signin input[name="password"],
            .form-signin input[name="name"]{
                margin-bottom: -1px;
                border-bottom-right-radius: 0;
                border-bottom-left-radius: 0;
            }

            .form-signin input[name="password"]{
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }

            .form-signin input[name="password_confirmation"]{
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </x-slot:style>
    <main class="form-signin">
        <form method="POST" action="{{route('password.update')}}">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <img class="mb-4" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Enter a new password</h1>

            @session('status')
                <x-alert type="info" :message="$value">
                    You can <a href="{{route('login')}}">now log in</a>
                </x-alert>
            @endsession

            @if ($errors->any())
                @foreach($errors->all() as $error)
                    <x-alert type="danger" :message="$error"></x-alert>
                @endforeach
            @endif

            <div class="form-floating">
                <input required type="email" name="email" class="form-control" value="{{old('email')}}" autocomplete="email" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input required type="password" name="password" autocomplete="new-password" class="form-control" id="floatingPassword" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input required type="password" name="password_confirmation" autocomplete="new-password" class="form-control" id="floatingRepeatPassword" placeholder="Password">
                <label for="floatingRepeatPassword">Password confirmation</label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Reset password</button>
            <a href="{{route('password.request')}}" class="mt-3 d-block small">Resend link</a>
            <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
        </form>
    </main>
</x-guest-layout>
