<div class="column column--md-{{$column['columns']}}{{$column['offset'] > 0 ? ' offset--md-'.$column['offset']: ''}}" data-column="{{$column['columns']}}" data-offset="{{$column['offset']}}">

    @if( array_key_exists($column['fragment']['fragment_type'], \Config::get('settings.fragment')) )
      @include('partials/fragment', ['fragment' => $column['fragment'], 'blueprint' => \Config::get('settings.fragment')[$column['fragment']['fragment_type']]] )
    @else
      @include('partials/fragment-missing', ['fragment' => $column['fragment']] )
    @endif

</div>
