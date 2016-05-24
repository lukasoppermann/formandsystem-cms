<?php
    // get old value
    $selected = old($name) === true ? 'checked' : (isset($checked) && $checked === true ? 'checked' : NULL);
    // get errors
    if( $errors->has($name) ){
        foreach( $errors->get($name) as $error ){
            $error_items[] = '<span class="o-input__error_item">'.$error.'</span>';
        }
        $error_messages = '<div class="o-input__errors">'.implode($error_items).'</div>';
    }
?>

<div class="o-toggle{{$errors->has($name) ? ' o-input--error' : ''}}">
    <input type="checkbox" id="{{$name}}" name="{{$name}}" class="o-toggle__checkbox" {{$selected or ''}}/>
    <label class="o-toggle__label" for="{{$name}}">
        <span class="o-toggle__switch"></span>
        <span class="o-toggle__text">{{$label}}</span>
    </label>
    {!! $error_messages or '' !!}
</div>
