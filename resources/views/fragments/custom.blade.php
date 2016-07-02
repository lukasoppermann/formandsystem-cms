<div class="">
    @if(!$fragment->fragments()->isEmpty())
        @foreach ($fragment->fragments() as $subfragment)
            <?php
                try{
                    $blueprint = config('custom.fragments')[$fragment->get('name')]->get('data')->get('elements')[$subfragment->get('name')];
                }catch(\Exception $e){
                    \Log::error($e);
                }
            ?>
            @if(isset($blueprint))
                @includeIf('fragments.'.$subfragment->get('type'), [
                'fragment'  => $subfragment,
                'label'     => isset($blueprint['label']) ? $blueprint['label'] : ''
                ])
            @endif
        @endforeach
    @endif
</div>
