<div class="o-file">
    <input type="file" name="{{$name}}" id="file" class="o-file__input" {{isset($disabled) ? 'disabled' : ''}} {!!$attr or ''!!}/>
    <label for="file" class="o-file__label{{isset($classes) ? ' '.trim($classes) : ''}}">{{$label}}</label>
</div>
