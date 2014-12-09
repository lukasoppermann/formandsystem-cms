<ul class="menu {!!$classes!!}">
  @foreach ($items as $item)
    @include('partials/menu-item', array_merge($item, ['language' => 'de']) )
  @endforeach
</ul>
