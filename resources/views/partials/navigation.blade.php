<?
  $items = Api::stream('navigation')->get(['limit' => 100, 'language' => Config::get('app.locale')]);
  dd($items);
?>

<nav class="navigation">
  <ul class="menu menu--fixed-top">
    <li class="menu-item menu--yellow">
      <a class="menu-link menu-link--icon-right" href="#">
        <svg viewBox="0 0 512 512" class="icon--dark icon--left">
          <use xlink:href="#icon-formandsystem"></use>
        </svg>
        <span class="menu-link-text">
          Dashboard
        </span>
      </a>
      <a href="#search" class="menu-link-icon search">
        <svg viewBox="0 0 512 512" class="icon-search icon--dark icon--left">
          <use xlink:href="#icon-search"></use>
        </svg>
      </a>
    </li>
  </ul>

  <ul class="menu menu-overflow">
    <li class="menu-li-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
      <ul class="menu">
        <li class="menu-li-item">
          <div class="menu-item is-active">

            <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
              <svg viewBox="0 0 512 512" class="icon-page icon--left">
                <use xlink:href="#icon-page"></use>
              </svg>
              <span class="menu-link-text menu-link-fade-right menu-link-fade-right--blue">Menü Eintrag Aktiv fdsasdfsdf sdfgsdf</span>
            </a>

            <a href="#visible" class="menu-item-status menu-link-icon menu-link--icon-right">
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

          <ul class="menu">
            <li class="menu-li-item">
              <div class="menu-item">
                <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
                  <svg viewBox="0 0 512 512" class="icon-page icon--left">
                    <use xlink:href="#icon-page"></use>
                  </svg>
                  <span class="menu-link-text menu-link-fade-right">Menü Eintrag dsfaasdfsdfasdfsdaf</span>
                </a>
                <a href="#visible" class="menu-item-status menu-link-icon menu-link--icon-right">
                  <svg viewBox="0 0 512 512" class="icon-eye icon--right">
                    <use xlink:href="#icon-eye"></use>
                  </svg>
                  <svg viewBox="0 0 512 512" class="icon-eye-closed icon--right">
                    <use xlink:href="#icon-eye-closed"></use>
                  </svg>
                </a>
              </div>
            <ul class="menu">
              <li class="menu-li-item">
                <div class="menu-item">
                  <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
                    <svg viewBox="0 0 512 512" class="icon-page icon--left">
                      <use xlink:href="#icon-page"></use>
                    </svg>
                    <span class="menu-link-text">Menü Eintrag</span>
                  </a>
                </div>
              </li>
              <li class="menu-li-item">
                <div class="menu-item">
                  <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
                    <svg viewBox="0 0 512 512" class="icon-page icon--left">
                      <use xlink:href="#icon-page"></use>
                    </svg>
                    <span class="menu-link-text">Menü Eintrag</span>
                  </a>
                </div>
              </li>
            </ul>
          </ul>
        </li>
        </li>
      </ul>
    </li>
    <li class="menu-li-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-li-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-li-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-li-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
      <ul class="menu">
        <li class="menu-item">
          <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
            <svg viewBox="0 0 512 512" class="icon-page icon--left">
              <use xlink:href="#icon-page"></use>
            </svg>
            <span class="menu-link-text">Menü Eintrag</span>
          </a>
        </li>
        <li class="menu-item">
          <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
            <svg viewBox="0 0 512 512" class="icon-page icon--left">
              <use xlink:href="#icon-page"></use>
            </svg>
            <span class="menu-link-text">Menü Eintrag</span>
          </a>
        </li>
        <li class="menu-item">
          <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
            <svg viewBox="0 0 512 512" class="icon-page icon--left">
              <use xlink:href="#icon-page"></use>
            </svg>
            <span class="menu-link-text">Menü Eintrag</span>
          </a>
        </li>
        <li class="menu-item">
          <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
            <svg viewBox="0 0 512 512" class="icon-page icon--left">
              <use xlink:href="#icon-page"></use>
            </svg>
            <span class="menu-link-text">Menü Eintrag</span>
          </a>
        </li>
      </ul>
    </li>
    <li class="menu-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
    <li class="menu-item">
      <a class="menu-link" rel="dns-prefetch" data-id="1" href="test">
        <svg viewBox="0 0 512 512" class="icon-page icon--left">
          <use xlink:href="#icon-page"></use>
        </svg>
        <span class="menu-link-text">Menü Eintrag</span>
      </a>
    </li>
  </ul>
    @yield('contentMenu','')

    <ul class="menu menu--fixed-bottom menu--dark">
      <li class="menu-item settings">
        <a class="menu-link menu-link--icon-right" href="#">
          <!-- <div class="icon-user icon--left"></div> -->
          <span class="menu-link-text menu-link-fade-right menu-link-fade-right--dark">Lukas Oppermannnnnnnnn</span>
        </a>
        <a href="#settings" class="menu-link-icon icon--white">
          <svg viewBox="0 0 512 512" class="icon-settings">
            <use xlink:href="#icon-settings"></use>
          </svg>
        </a>
      </li>
    </ul>
</nav>
