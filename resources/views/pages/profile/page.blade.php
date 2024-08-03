<x-app class="page">
    <img src="{{$user->avatar ?? 'https://via.placeholder.com/160'}}" class="page__avatar" alt="profile picture">
    <h1 class="text-center ">{{$user->first_name}} {{$user->last_name ?? ''}}</h1>

    <div class="page-card">
        <ul class="d-flex align-items-center justify-content-center social-links-list">
            @foreach($user->socialNetworks as $link)
                @if(!is_null($link->pivot->link) && !$link->pivot->hidden)
                    <li class="me-3">
                        <a href="{{$link->url_pattern}}{{$link->pivot->link}}"><i class="bi bi-{{$link->name}}"></i></a>
                    </li>
                @endif
            @endforeach
        </ul>

        <ul class="basic-info-list my-4">
            @if(isset($user->home_tel))
                <li class="d-flex align-items-center justify-content-between">
                    <a href="tel:{{$user->home_tel}}">
                        {{$user->home_tel}}
                        <span class="small">(home)</span>
                    </a>
                    <i class="bi bi-telephone ms-4"></i>
                </li>
            @endif

            @if(isset($user->work_tel))
                <li class="d-flex align-items-center justify-content-between">
                    <a href="{{$user->work_tel}}">
                        {{$user->work_tel}}
                        <span class="small">(work)</span>
                    </a>
                    <i class="bi bi-phone ms-4"></i>
                </li>
            @endif

            @if(isset($user->website))
                <li class="d-flex align-items-center justify-content-between">
                    <a href="{{$user->website}}">{{$user->website}}</a>
                    <i class="bi bi-globe"></i>
                </li>
            @endif

            <li class="d-flex align-items-center justify-content-between">
                <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                <i class="bi bi-envelope ms-4"></i>
            </li>

            @if($user->locations->isNotEmpty())
                <li class="d-flex align-items-center justify-content-between">
                    {{$user->locations->first()->street ?? ''}}
                    {{$user->locations->first()->city ?? ''}}
                    {{$user->locations->first()->country ?? ''}}
                    {{$user->locations->first()->postcode ?? ''}}
                    <i class="bi bi-pin-map ms-4"></i>
                </li>
            @endif
        </ul>

        <ul class="basic-info-list my-4">
            @if(isset($user->company))
                <li>
                    Company: {{$user->company}}
                </li>
            @endif

            @if(isset($user->job_title))
                <li>
                    Job title: {{$user->job_title}}
                </li>
            @endif
        </ul>

        {{--    <a href="{{route('user.vcard.download', $user->user_hash)}}" class="btn btn-info">Download vcard</a>--}}
        <a href="{{Storage::disk('s3')->url($hash.'.vcf')}}" download class="btn w-100 page-btn sticky-bottom d-flex align-items-center justify-content-center">
            <i class="bi bi-download me-4"></i>
            Save to your contacts
        </a>

        <a href="{{route('welcome')}}" class="btn w-100 mt-4 promo-btn d-flex align-items-center justify-content-center">
            Create your own card!
        </a>
    </div>
</x-app>
