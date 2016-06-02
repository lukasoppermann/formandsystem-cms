<?php
    // get old value

    $value = old($name) !== NULL ? old($name) : (isset($value) ? $value : NULL);
    // get errors
    if( $errors->has($name) ){
        foreach( $errors->get($name) as $error ){
            $error_items[] = '<span class="o-input__error_item">'.$error.'</span>';
        }
        $error_messages = '<div class="o-input__errors">'.implode($error_items).'</div>';
    }
    // get additional values
    $additional_values = isset($additional_values) ? array_filter($additional_values) : [];
?>

<div class="o-input{{$errors->has($name) ? ' o-input--error' : ''}}">
    @foreach($additional_values as $key => $v)
        <input name="{{$name}}_{{$key}}" type="hidden" value="{{$v}}">
    @endforeach

    <input class="o-input__input{{$value == NULL ? ' is-empty' : ''}}" name="{{$name}}" type="{{$type or 'text'}}"  value="{{$value or ''}}" spellcheck="false" {{$attr or ''}} data-check-empty>
    <span class="o-input__bar"></span>
    <label class="o-input__label">{{$label}}</label>
    {!! $error_messages or '' !!}
</div>
