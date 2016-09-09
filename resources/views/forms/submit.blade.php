<input
    type="submit"
    value="{{$label}}"
    name="{{$name or ''}}"
    class="{{isset($classes) ? $classes : 'o-button o-button--blue'}}"
    {{isset($disabled) ? 'disabled' : ''}}
    {{$attr or ''}}
>
