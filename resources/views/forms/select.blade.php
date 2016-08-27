<?php
    $errors = isset($error_bag) ? $errors->{$error_bag} : $errors;
    // get old value
    $selected = old($name) !== NULL ? old($name) : (isset($selected) ? $selected : NULL);
    // get errors
    if( $errors->has($name) ){
        foreach( $errors->get($name) as $error ){
            $error_items[] = '<span class="o-input__error_item">'.$error.'</span>';
        }
        $error_messages = '<div class="o-input__errors">'.implode($error_items).'</div>';
    }
?>
<div class="o-select-box{{$errors->has($name) ? ' o-input--error' : ''}}">
    <label class="o-select__label">{{$label}}</label>
    <div class="o-select">
        <select class="" name="{{$name}}" {{$attr or ''}}>
            @foreach ($values as $key => $value)
                <option value="{{$key}}" {{$key == $selected ? 'selected' : ''}}>{{$value}}</option>
            @endforeach
        </select>
    </div>
    {!! $error_messages or '' !!}
</div>
