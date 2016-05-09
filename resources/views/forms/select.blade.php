<div class="o-select-box">
    <label class="o-select__label">{{$label}}</label>
    <div class="o-select">
        <select class="" name="{{$name}}">
            @foreach ($values as $key => $value)
                <option value="{{$key}}" {{$key === $selected ? 'selected' : ''}}>{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>
