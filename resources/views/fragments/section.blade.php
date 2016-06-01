<!-- include sub-fragments -->
<div class="o-grid">
    @if($fragment->fragments !== NULL)
        @foreach($fragment->fragments as $subfragment)
            @include('fragments.fragment', ['fragment' => $subfragment, 'page' => $page])
        @endforeach
    @endif

    @include('fragments.new', ['fragment_id' => $fragment->id])
</div>
