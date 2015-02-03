<?
  // $items = [
  //   'success' => 1,
  //   'status_code' => 200,
  //   'more_info' => 'http://dev.formandsystem.com/pages#get',
  //   'data' => [
  //     [
  //       'article_id' => 1,
  //       'stream_record_id' => 1,
  //       'stream' => 'navigation',
  //       'position' => 1,
  //       'parent_id' => 0,
  //       'content' => [
  //         'de' => [
  //           'id' => 1,
  //           'article_id' => 1,
  //           'menu_label' => 'Home',
  //           'link' => 'home',
  //           'published' => 1,
  //           'language' => 'de',
  //           'data' => []
  //         ],
  //         'en' => [
  //           'id' => 4,
  //           'article_id' => 1,
  //           'menu_label' => 'Home',
  //           'link' => 'home',
  //           'published' => 1,
  //           'language' => 'en',
  //           'data' => []
  //         ]
  //       ],
  //       'children' => [
  //         [
  //           'article_id' => 2,
  //           'stream_record_id' => 2,
  //           'stream' => 'navigation',
  //           'position' => 1,
  //           'parent_id' => 0,
  //           'content' => [
  //             'de' => [
  //               'id' => 1,
  //               'article_id' => 1,
  //               'menu_label' => 'Subhome',
  //               'link' => 'subhome',
  //               'published' => 1,
  //               'language' => 'de',
  //               'data' => [],
  //             ]
  //           ],
  //           'children' => [
  //             [
  //               'article_id' => 2,
  //               'stream_record_id' => 2,
  //               'stream' => 'navigation',
  //               'position' => 1,
  //               'parent_id' => 0,
  //               'content' => [
  //                 'de' => [
  //                   'id' => 1,
  //                   'article_id' => 1,
  //                   'menu_label' => 'Subsubhome',
  //                   'link' => 'Subsubhome',
  //                   'published' => 0,
  //                   'language' => 'de',
  //                   'data' => []
  //                 ]
  //               ],
  //               'children' => [
  //                 [
  //                   'article_id' => 2,
  //                   'stream_record_id' => 2,
  //                   'stream' => 'navigation',
  //                   'position' => 1,
  //                   'parent_id' => 0,
  //                   'content' => [
  //                     'de' => [
  //                       'id' => 1,
  //                       'article_id' => 1,
  //                       'menu_label' => 'Subsubhome',
  //                       'link' => 'Subsubhome',
  //                       'published' => 0,
  //                       'language' => 'de',
  //                       'data' => []
  //                     ]
  //                   ]
  //                 ]
  //               ]
  //             ]
  //           ]
  //         ]
  //       ]
  //     ],
  //     [
  //       'article_id' => 1,
  //       'stream_record_id' => 1,
  //       'stream' => 'navigation',
  //       'position' => 1,
  //       'parent_id' => 0,
  //       'content' => [
  //         'de' => [
  //           'id' => 1,
  //           'article_id' => 1,
  //           'menu_label' => 'About',
  //           'link' => 'about',
  //           'published' => 1,
  //           'language' => 'de',
  //           'data' => []
  //         ]
  //       ]
  //     ]
  //   ]
  // ];

  // $items = $items['data'];
  $items = Api::stream('navigation')->get(['limit' => 100, 'language' => \Config::get('content.locale')])['data'];

?>

<nav class="navigation">
  @include('shamefiles/menu-item-dashboard')
  @include('partials/menu', ['items' => $nav_items, 'template' => $template, 'classes' => 'menu--overflow'])
</nav>
