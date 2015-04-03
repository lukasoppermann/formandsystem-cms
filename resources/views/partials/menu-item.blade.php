<?
if( !isset($item['content'][\Config::get('content.locale')]) ){
  return;
}
$content = $item['content'][\Config::get('content.locale')];
?>

<li class="menu-li-item">
  <div class="menu-item{{ \Request::is('pages/'.$content['link']) ? ' is-active js-is-active' : ''}}">

    <a class="menu-link o-media" rel="dns-prefetch" data-id="1" href="{{url("pages/".$content['link'])}}">
      <svg viewBox="0 0 512 512" class="o-icon o-icon--white o-media__figure">
        <use xlink:href="#icon-page"></use>
      </svg>
      <span class="menu-link-text menu-link-fade-right menu-link-fade-right o-media__body">{{$content['menu_label']}}</span>
    </a>

    <a href="#visible" class="menu-item-status{{ ($content['published'] === 1 ? ' is-published': '')}} menu-link-icon menu-link--icon-right">
      <svg viewBox="0 0 512 512" class="icon-eye o-icon o-icon--white">
        <use xlink:href="#icon-eye"></use>
      </svg>
      <svg viewBox="0 0 512 512" class="icon-eye-closed o-icon o-icon--white">
        <use xlink:href="#icon-eye-closed"></use>
      </svg>
    </a>
  </div>
  <div class="menu-item-options{{ \Request::is('pages/'.$content['link']) ? ' is-active':''}}">
    <label class="menu-item-options-link o-media o-box--pad-v-md o-box--pad-h-sm">
      <svg viewBox="0 0 512 512" class="o-icon o-icon--white o-media__figure">
        <use xlink:href="#icon-link"></use>
      </svg>
      <input class="link-input o-media__body" type="text" value="{{$content['link'] or ''}}" placeholder="/link-to-page" />
    </label>
    <div class="menu-item-options-bottom">
      <a class="menu-item-options-delete" href="'.url('/content/destroy/'.$itemContent['id']).'">delete</a>
    </div>
  </div>

  @if( isset($item['children']) && count($item['children']) > 0 )
      @include('partials/menu', ['items' => $item['children'], 'classes' => ''])
  @endif

</li>
