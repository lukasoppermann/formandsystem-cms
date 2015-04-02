<ul class="menu {!!$classes!!}">
  <!-- TODO: remove -->
  <? \Config::set('content.locale','de'); ?>
  @foreach ($items as $item)
    @include($template, ['item' => $item] )
  @endforeach
</ul>
