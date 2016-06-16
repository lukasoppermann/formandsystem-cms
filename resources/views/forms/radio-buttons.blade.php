<?php
    $selected = isset($selected) ? $selected : NULL;
?>
<div class="o-radio-group o-grid">
    @foreach ($values as $value => $label)
        <label for="{{$value}}" class="o-radio-button {{$classes or ''}}">
            <input type="radio" name="{{$name}}" id="{{$value}}" value="{{$value}}" {{$selected === $value ? 'checked' : ''}} onchange='form.submit();'/>
            <span>{{$label}}</span>
        </label>
    @endforeach
</div>
