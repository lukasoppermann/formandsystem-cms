<div class="o-fragment o-fragment--{{$fragment->type}} o-grid__column o-grid__user-column--md-{{$fragment->details->get('columns_medium', '12')}}of{{config('user.grid-md')}}">

    @include('fragments.settings')

    <div class="c-settings-panel__toggle c-settings-panel__toggle--right c-settings-panel__toggle--small" data-toggle-dialog="fragment-settings-{{$fragment->id}}">
        <svg viewBox="0 0 512 512" class="o-icon">
          <use xlink:href="#svg-icon--settings"></use>
        </svg>
    </div>

    @include('fragments.'.$fragment->type, ['fragment' => $fragment, 'page' => $page])

</div>
