<x-guest-layout class="d-flex h-100 text-center text-white bg-dark">
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

            .btn-secondary,
            .btn-secondary:hover,
            .btn-secondary:focus {
                color: #333;
                text-shadow: none; /* Prevent inheritance from `body` */
            }


            /*
             * Base structure
             */

            body {
                text-shadow: 0 .05rem .1rem rgba(0, 0, 0, .5);
                box-shadow: inset 0 0 5rem rgba(0, 0, 0, .5);
            }

            .cover-container {
                max-width: 42em;
            }


            /*
             * Header
             */

            .nav-masthead .nav-link {
                padding: .25rem 0;
                font-weight: 700;
                color: rgba(255, 255, 255, .5);
                background-color: transparent;
                border-bottom: .25rem solid transparent;
            }

            .nav-masthead .nav-link:hover,
            .nav-masthead .nav-link:focus {
                border-bottom-color: rgba(255, 255, 255, .25);
            }

            .nav-masthead .nav-link + .nav-link {
                margin-left: 1rem;
            }

            .nav-masthead .active {
                color: #fff;
                border-bottom-color: #fff;
            }
        </style>
    </x-slot:style>
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
        <x-header class="mb-auto" mode="dark"></x-header>

        <main class="px-3">
            <h1>Virtual business card.</h1>
            <p class="lead">Online service for creating business cards from a mobile application or a company's web account.</p>
            <p class="lead">
                <a href="{{route('pricing')}}" class="btn btn-lg btn-secondary fw-bold border-white bg-white">Learn more</a>
            </p>
        </main>

        <x-footer class="mt-auto"></x-footer>
    </div>
</x-guest-layout>

