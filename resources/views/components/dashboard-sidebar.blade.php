@props(['class'=>''])
<aside {{$attributes->merge(['class'=>'pt-5 '.$class])}}>
    {{$slot}}
</aside>
