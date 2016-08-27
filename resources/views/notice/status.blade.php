@if( session('status') !== null)
    <div class="o-status o-status--{{session('type')}}" data-target="status">
        <div data-hide="status" class="o-status__hide">×</div>
        {{session('status')}}
    </div>
@endif
