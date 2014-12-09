<?
  // $items = Api::stream('navigation')->get(['limit' => 100, 'language' => Config::get('app.locale')]);
  $items = [
    'success' => 1,
    'status_code' => 200,
    'more_info' => 'http://dev.formandsystem.com/pages#get',
    'data' => [
      [
        'article_id' => 1,
        'stream_record_id' => 1,
        'stream' => 'navigation',
        'position' => 1,
        'parent_id' => 0,
        'content' => [
          'de' => [
            'id' => 1,
            'article_id' => 1,
            'menu_label' => 'Home',
            'link' => 'home',
            'published' => 1,
            'language' => 'de',
            'data' => []
          ],
          'en' => [
            'id' => 4,
            'article_id' => 1,
            'menu_label' => 'Home',
            'link' => 'home',
            'published' => 1,
            'language' => 'en',
            'data' => []
          ]
        ],
        'children' => [
          [
            'article_id' => 2,
            'stream_record_id' => 2,
            'stream' => 'navigation',
            'position' => 1,
            'parent_id' => 0,
            'content' => [
              'de' => [
                'id' => 1,
                'article_id' => 1,
                'menu_label' => 'Subhome',
                'link' => 'subhome',
                'published' => 1,
                'language' => 'de',
                'data' => [],
              ]
            ],
            'children' => [
              [
                'article_id' => 2,
                'stream_record_id' => 2,
                'stream' => 'navigation',
                'position' => 1,
                'parent_id' => 0,
                'content' => [
                  'de' => [
                    'id' => 1,
                    'article_id' => 1,
                    'menu_label' => 'Subsubhome',
                    'link' => 'Subsubhome',
                    'published' => 0,
                    'language' => 'de',
                    'data' => []
                  ]
                ],
                'children' => [
                  [
                    'article_id' => 2,
                    'stream_record_id' => 2,
                    'stream' => 'navigation',
                    'position' => 1,
                    'parent_id' => 0,
                    'content' => [
                      'de' => [
                        'id' => 1,
                        'article_id' => 1,
                        'menu_label' => 'Subsubhome',
                        'link' => 'Subsubhome',
                        'published' => 0,
                        'language' => 'de',
                        'data' => []
                      ]
                    ]
                  ]
                ]
              ]
            ]
          ]
        ]
      ],
      [
        'article_id' => 1,
        'stream_record_id' => 1,
        'stream' => 'navigation',
        'position' => 1,
        'parent_id' => 0,
        'content' => [
          'de' => [
            'id' => 1,
            'article_id' => 1,
            'menu_label' => 'About',
            'link' => 'about',
            'published' => 1,
            'language' => 'de',
            'data' => []
          ]
        ]
      ]
    ]
  ];

  $items = $items['data'];
?>



<nav class="navigation">

  @include('shamefiles/menu-item-dashboard')
    @include('partials/menu', ['items' => $items, 'classes' => 'menu-overflow'])
  @include('shamefiles/menu-item-user')

</nav>



<!-- <ul class="menu menu-overflow">
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
-->
