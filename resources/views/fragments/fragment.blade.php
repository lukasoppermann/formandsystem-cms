
<div class="o-fragmen
t o-fragment--{{$item->type}} o-grid__column o-grid__user-column--md-{{$item->details->get('columns_medium', '12')}}of{{config('user.grid-md')}}">

    @include('fragments.settings')

    <div class="c-settings-panel__toggle c-settings-panel__toggle--right c-settings-panel__toggle--small" data-toggle-dialog="fragment-settings-{{$item->id}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--settings"></use>
        </svg>
    </div>

    @if (in_array($item->type, ['image','section','text']))
        @include('fragments.'.$item->type)
    @else
        @include('fragments.custom')
    @endif



</div>
