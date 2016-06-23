<div class="o-fragment o-fragment--{{$item->type}} o-grid__column o-grid__user-column--md-{{$item->details->get('columns_medium', '12')}}of{{config('user.grid-md')}}">

    <div class="c-settings-panel__toggle c-settings-panel__toggle--right c-settings-panel__toggle--small" data-toggle-dialog="fragment-settings-{{$item->id}}" data-dialog-link="/dialog/fragmentSettings?id={{$item->id}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--settings"></use>
        </svg>
    </div>

    @if (in_array($item->type, ['image','section','text','collection']))
        @include('fragments.'.$item->type, ['fragment' => $item])
    @else
        @include('fragments.custom', ['fragment' => $item])
    @endif



</div>
