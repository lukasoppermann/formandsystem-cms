<div class="">
    @if(!$fragment->relationships->get('fragments')->isEmpty())
        @foreach ($fragment->relationships->get('fragments') as $subfragment)
            <?php
                $blueprint = config('custom.fragments')[$fragment->name]->data->get('elements')[$subfragment->name];
            ?>
            @includeIf('fragments.'.$subfragment->type, [
                'fragment'  => $subfragment,
                'label'     => isset($blueprint['label']) ? $blueprint['label'] : ''
            ])
        @endforeach
    @endif
</div>
