<div class="">
    @if(!$fragment->fragments()->isEmpty())
        @foreach ($fragment->fragments() as $subfragment)
            <?php
                $blueprint = config('custom.fragments')[$fragment->get('name')]->get('data')->get('elements')[$subfragment->get('name')];
            ?>
            @includeIf('fragments.'.$subfragment->get('type'), [
                'fragment'  => $subfragment,
                'label'     => isset($blueprint['label']) ? $blueprint['label'] : ''
            ])
        @endforeach
    @endif
</div>
