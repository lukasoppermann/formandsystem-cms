<div class="fragment js-fragment">
  <div class="dragger"></div>
  @foreach($blueprint['setting']['fields'] as $name => $type)

    @if( view()->exists("input/$type") )
      @include("input/$type", ['name' => $name, 'data' => $fragment['content'][$name] ])
    @endif

  @endforeach
</div>
