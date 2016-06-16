{{$item->type}}
@foreach ($fragment->toArray() as $key => $section)
    @if(isset($section['type']) && $section['type'] === 'markdown')
        test
        <textarea name="name" rows="8" cols="40"></textarea>
    @endif
@endforeach
