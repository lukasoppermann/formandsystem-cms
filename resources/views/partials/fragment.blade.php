<div class="fragment js-fragment"
  data-fragment-id="{{$fragment['fragment_id']}}"
  {{ isset($fragment['fragment_key']) ? 'data-fragment-key="'.$fragment['fragment_key'].'"' : ''}}
  data-fragment-type="{{$fragment['fragment_type']}}"
>
  @foreach($blueprint['setting']['fields'] as $name => $type)

    @if( view()->exists("input/$type") )
      @include("input/$type", ['name' => $name, 'data' => $fragment['content'][$name] ])
    @endif

  @endforeach
</div>
