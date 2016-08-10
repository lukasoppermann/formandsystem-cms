<?php
    $id = rand(1000000,9999999);
?>
<div class="o-file">
    <input id="file-{{$id}}" type="file" name="{{$name}}" id="file" class="o-file__input" {{isset($disabled) ? 'disabled' : ''}} {!!$attr or ''!!}/>
    <label for="file-{{$id}}" class="o-file__label{{isset($classes) ? ' '.trim($classes) : ''}}">{{$label}}</label>
</div>
