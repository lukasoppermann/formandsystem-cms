<ul class="menu {!!$classes!!}">
  <!-- TODO: remove -->
  <? \Config::set('content.locale','de'); ?>

  @foreach ($items as $item)
    @include('partials/menu-item', ['item' => $item] )
  @endforeach
</ul>
