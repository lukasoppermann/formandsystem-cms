<?php
    // get old value
    $checked = old($name) === 'true' ? 'checked' : (isset($value) && ($value === 1 || $value === true) ? 'checked' : NULL);
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

<div class="o-toggle{{$errors->has($name) ? ' o-input--error' : ''}}">
    @foreach($additional_values as $key => $v)
        <input name="{{$name}}_{{$key}}" type="hidden" value="{{$v}}">
    @endforeach

    <input type="checkbox" id="{{$name}}" name="{{$name}}" value="true" class="o-toggle__checkbox" {{$checked or ''}}/>
    <label class="o-toggle__label" for="{{$name}}">
        <span class="o-toggle__switch"></span>
        <span class="o-toggle__text">{{$label}}</span>
    </label>
    {!! $error_messages or '' !!}
</div>
