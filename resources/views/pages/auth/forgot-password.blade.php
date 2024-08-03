<x-guest-layout>
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

            .form-signin input[type="email"] {
                margin-bottom: -1px;
            }

        </style>
    </x-slot:style>
    <main class="form-signin">
        <form method="POST" action="{{route('password.request')}}">
            @csrf
            <img class="mb-4" src="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Enter your email</h1>

            @session('status')
                <x-alert type="info" :message="$value"></x-alert>
            @endsession

            @if ($errors->any())
                @foreach($errors->all() as $error)
                    <p class="alert alert-danger">
                        {{$error}}
                    </p>
                @endforeach
            @endif

            <div class="form-floating">
                <input required type="email" name="email" value="{{old('email')}}" class="mb-3 form-control" id="floatingInput" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Reset password</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
        </form>
    </main>
</x-guest-layout>
