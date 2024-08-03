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

            body {
                background-image: linear-gradient(180deg, #eee, #fff 100px, #fff);
            }

            .container {
                max-width: 960px;
            }

            .pricing-header {
                max-width: 700px;
            }
        </style>
    </x-slot:style>
    <x-header></x-header>

    <div class="pricing-header p-3 pb-md-4 mx-auto text-center">
        <h1 class="display-4 fw-normal">Pricing</h1>
        <p class="fs-5 text-muted">Quickly build an effective pricing table for your potential customers with this Bootstrap example. It’s built with default Bootstrap components and utilities with little customization.</p>
    </div>

    <main>
        <div class="container">
            <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Free trial (14 days)</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">$0<small class="text-muted fw-light">/mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>10 users included</li>
                                <li>2 GB of storage</li>
                                <li>Email support</li>
                                <li>Help center access</li>
                            </ul>
                            <a href="{{route('register')}}" class="w-100 btn btn-lg btn-outline-primary">Sign up for free</a>
                        </div>
                    </div>
                </div>

                <div class="col mx-auto">
                    <div class="card mb-4 rounded-3 shadow-sm">
                        <div class="card-header py-3">
                            <h4 class="my-0 fw-normal">Monthly</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">{{config('app.price.sign')}} {{config('app.price.monthly')}}<small class="text-muted fw-light">/mo</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>20 users included</li>
                                <li>10 GB of storage</li>
                                <li>Priority email support</li>
                                <li>Help center access</li>
                            </ul>
                            <a href="{{route('payment.create', 'monthly')}}" class="w-100 btn btn-lg btn-primary">Get started</a>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card mb-4 rounded-3 shadow-sm border-primary">
                        <div class="card-header py-3 text-white bg-primary border-primary">
                            <h4 class="my-0 fw-normal">Annual</h4>
                        </div>
                        <div class="card-body">
                            <h1 class="card-title pricing-card-title">{{config('app.price.sign')}} {{config('app.price.annual')}}<small class="text-muted fw-light">/year</small></h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li>30 users included</li>
                                <li>15 GB of storage</li>
                                <li>Phone and email support</li>
                                <li>Help center access</li>
                            </ul>
                            <a href="{{route('payment.create', 'annual')}}" class="w-100 btn btn-lg btn-primary">Get started</a>
                        </div>
                    </div>
                </div>
            </div>

            @if($errors->any())
                <x-alert type="danger" class="mt-3" :message="$errors->first()"></x-alert>
            @endif
        </div>
    </main>

    <x-footer></x-footer>
</x-guest-layout>
