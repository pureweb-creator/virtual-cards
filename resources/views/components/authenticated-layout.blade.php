<x-app>
    <x-slot:style>{{$style ?? ''}}</x-slot:style>

    {{$header ?? ''}}

    <div class="container-fluid">
        <div class="row">
            {{$slot}}
        </div>
    </div>

    <x-slot:scripts>
        {{$scripts ?? ''}}
    </x-slot:scripts>
</x-app>
