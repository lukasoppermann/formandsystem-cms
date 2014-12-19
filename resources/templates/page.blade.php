@extends('partials/app')

@section('content')
  @if( count($content['sections']) > 0 )
    @each('partials/section', $content['sections'], 'section')
  @endif
  <ul class="parent" style="list-style: circle; margin: 10px;">
    <li><span>Item One</span>
      <ul class="child" style="list-style: circle; margin: 10px;">
        <li>Sub Item 1</li>
        <li>Sub Item 2</li>
        <li>Sub Item 3</li>
      </ul>
    </li>
    <li><span>Item Two</span>
      <ul class="child" style="list-style: circle; margin: 10px;">
        <li>Sub Item 4</li>
        <li>Sub Item 5</li>
      </ul>
    </li>
    <li><span>Final Item</span>
      <ul class="child" style="list-style: circle; margin: 10px;">
        <li>Sub Item 6</li>
        <li>Sub Item 7</li>
      </ul>
    </li>
  </ul>

@stop
