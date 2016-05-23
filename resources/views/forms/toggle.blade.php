<?php
    // get old value
    $selected = isset($request) ? $request->old($name) : NULL;
    // get errors
    if( $errors->has($name) ){
        foreach( $errors->get($name) as $error ){
            $error_items[] = '<span class="o-input__error_item">'.$error.'</span>';
        }
        $error_messages = '<div class="o-input__errors">'.implode($error_items).'</div>';
    }
?>

<div class="o-select-box  {{$errors->has($name) ? 'o-input--error' : ''}}">
    <label class="o-select__label">{{$label}}</label>
    <div class="o-select">
        <select class="" name="{{$name}}">
            <option value="1" {{'true' === $selected ? 'selected' : ''}}>True</option>
            <option value="0" {{'true' === $selected ? 'selected' : ''}}>False</option>
        </select>
    </div>
    {!! $error_messages or '' !!}
</div>
