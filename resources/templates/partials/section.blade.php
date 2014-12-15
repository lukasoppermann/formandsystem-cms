@foreach ($section as $fragment) 
  @include('partials/fragment', ['fragment' => $fragment] )
@endforeach
