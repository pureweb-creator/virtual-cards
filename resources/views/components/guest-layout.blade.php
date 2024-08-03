@props(['class'=>null])

<x-app class="text-center {{$class}}">
    <x-slot:style>{{$style ?? ''}}</x-slot:style>
    {{$slot}}
</x-app>
