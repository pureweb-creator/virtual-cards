@props(['type'=>'', 'class'=>'', 'message'=>''])
<p {{$attributes->merge(['class'=>'alert alert-'.$type.' '.$class])}}>
    {{$message}}
    {{$slot}}
</p>
