<div class="">
    @if(!$fragment->fragments()->isEmpty())
        @if(is_array($fragment->get('data')) && isset($fragment->get('data')['elements']))
            @foreach ($fragment->get('data')['elements'] as $element)
                @includeIf('fragments.'.$element['type'], [
                    'fragment'      => $fragment->fragments('name',(isset($element['name']) ? $element['name'] : ''),true),
                    'label'         => isset($element['label']) ? $element['label'] : '',
                    'spawn'         => isset($element['spawn']) ? $element['spawn'] : NULL,
                    'parentType'    => 'fragment',
                    'parentId'      => $fragment->get('id')
                ])
            @endforeach
        @endif
    @endif
</div>
