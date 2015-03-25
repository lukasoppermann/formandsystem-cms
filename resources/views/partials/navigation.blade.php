<nav class="navigation">
  @include('shamefiles/menu-item-dashboard')
  @include('partials/menu', ['items' => $items, 'template' => $template, 'classes' => 'menu--overflow'])
</nav>
