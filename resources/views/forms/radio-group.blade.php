<?php
    $selected = isset($selected) ? $selected : NULL;
?>
<div class="o-radio-group o-grid">
    @foreach ($values as $value => $label)
        <label for="{{$value}}" class="o-radio-button {{$classes or ''}}">
            <input type="radio" name="{{$name}}" id="{{$value}}" value="{{$value}}" {{$selected === $value ? 'checked' : ''}} data-submit-form="newCollection"/>
            <div class="o-button-radio__label">{{$label}}</div>
        </label>
    @endforeach
</div>
