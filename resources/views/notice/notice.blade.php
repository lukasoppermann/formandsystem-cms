<div class="o-notice o-notice--{{$type or 'default'}} {{$class or ''}}">
    @if(isset($template))
        @include($template, $data)
    @else
        {{$data}}
    @endif
</div>
