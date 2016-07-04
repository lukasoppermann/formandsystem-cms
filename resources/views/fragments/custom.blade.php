<div class="">
    @if(!$fragment->fragments()->isEmpty())
        {{-- @foreach ($fragment->fragments() as $subfragment)
            @if(is_array($fragment->get('data')))
                @includeIf('fragments.'.$subfragment->get('type'), [
                'fragment'  => $subfragment,
                    'label'     => isset($blueprint['label']) ? $blueprint['label'] : ''
                ])
            @endif
        @endforeach --}}
        @if(is_array($fragment->get('data')) && isset($fragment->get('data')['elements']))
            @foreach ($fragment->get('data')['elements'] as $element)
                @includeIf('fragments.'.$element['type'], [
                    'fragment'  => $fragment->fragments('name',$element['name'],true),
                    'label'     => isset($element['label']) ? $element['label'] : ''
                ])
            @endforeach
        @endif
    @endif
</div>
