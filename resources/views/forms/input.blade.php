<?php
    // get old value
    $value = isset($request) ? $request->old($name) : NULL;
    // get errors
    if( $errors->has($name) ){
        foreach( $errors->get($name) as $error ){
            $error_items[] = '<span class="o-input__error_item">'.$error.'</span>';
        }
        $error_messages = '<div class="o-input__errors">'.implode($error_items).'</div>';
    }
?>

<div class="o-input {{$errors->has($name) ? 'o-input--error' : ''}}">
    <input class="o-input__input" name="{{$name}}" type="{{$type or 'text'}}"  value="{{$value or ''}}" required spellcheck="false">
    <span class="o-input__bar"></span>
    <label class="o-input__label">{{$label}}</label>
    {!! $error_messages or '' !!}
</div>
