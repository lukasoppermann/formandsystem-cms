<!-- include sub-fragments -->
<div class="o-user-grid">
    @if($fragment->fragments !== NULL)
        @foreach($fragment->fragments as $subfragment)
            @include('fragments.fragment', ['fragment' => $subfragment])
        @endforeach
    @endif

    @include('fragments.new', ['fragment_id' => $fragment->id])
</div>
