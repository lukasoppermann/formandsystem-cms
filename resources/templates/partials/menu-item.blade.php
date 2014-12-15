<?
$content = $item['content'][\Config::get('content.locale')];
?>

<li class="menu-li-item">
  <div class="menu-item">

    <a class="menu-link" rel="dns-prefetch" data-id="1" href="{{url("pages/".$content['link'])}}">
      <svg viewBox="0 0 512 512" class="icon-page icon--left">
        <use xlink:href="#icon-page"></use>
      </svg>
      <span class="menu-link-text menu-link-fade-right menu-link-fade-right">
        {{$content['menu_label']}}
      </span>
    </a>

    <a href="#visible" class="menu-item-status<?=($content['published'] === 1 ? ' is-published': '')?> menu-link-icon menu-link--icon-right">
      <svg viewBox="0 0 512 512" class="icon-eye icon--right">
        <use xlink:href="#icon-eye"></use>
      </svg>
      <svg viewBox="0 0 512 512" class="icon-eye-closed icon--right">
        <use xlink:href="#icon-eye-closed"></use>
      </svg>
    </a>
  </div>
  <div class="menu-item-options">
    <label class="menu-item-options-link">
      <svg viewBox="0 0 512 512" class="icon-link icon--left">
        <use xlink:href="#icon-link"></use>
      </svg>
      <input class="link-input" type="text" value="" placeholder="/link-to-page" />
    </label>
    <div class="menu-item-options-bottom">
      <a class="menu-item-options-delete" href="'.url('/content/destroy/'.$itemContent['id']).'">delete</a>
    </div>
  </div>

  @if( isset($item['children']) && count($item['children']) > 0 )
      @include('partials/menu', ['items' => $item['children'], 'classes' => ''])
  @endif

</li>
