<div class="fragment js-fragment"
  data-fragment-id="{{$fragment['fragment_id']}}"
  {{ isset($fragment['fragment_key']) ? 'data-fragment-key="'.$fragment['fragment_key'].'"' : ''}}
  data-fragment-type="{{$fragment['fragment_type']}}"
>
<div class="fragment-settings-button" data-toggle-target="fragment-settings-content-{{$fragment['fragment_id']}}">
  <svg viewBox="0 0 512 512" class="icon-settings o-icon--darkest-gray">
    <use xlink:href="#icon-settings"></use>
  </svg>
</div>

<div class="fragment-settings-content" data-toggle="fragment-settings-content-{{$fragment['fragment_id']}}">
  <div class="input-field">
    <label for="fragment-class-{{$fragment['fragment_id']}}">@lang('content.additional_classes')</label>
    <input name="fragment-class-{{$fragment['fragment_id']}}" type="text" value="{{$fragment['fragment_data']['class'] or ''}}" />
  </div>
</div>

  @foreach($blueprint['setting']['fields'] as $name => $type)

    @if( view()->exists("input/$type") )
      @include("input/$type", ['name' => $name, 'data' => $fragment['fragment_data'][$name] ])
    @endif

  @endforeach
</div>
