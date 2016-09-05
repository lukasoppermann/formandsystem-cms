<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Menu\Html;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Link;
use Spatie\Menu\HasUrl;
use Spatie\Menu\Helpers\Reflection;

class spatieHTML extends HTML implements HasUrl{

     protected $prefixes = [];
     protected $url = [];

    protected function __construct(string $html, string $url = null)
    {
        $this->html = $html;
        $this->url = $url;
        $this->active = false;
        $this->initializeParentAttributes();
    }

    public static function make(string $html, $url = 'null')
    {
        return new static($html, $url);
    }

    public function getUrl(): string
   {
       if (empty($this->prefixes)) {
           return $this->url;
       }
       return implode('', $this->prefixes) . '/' . ltrim($this->url, '/');
   }

   public function segment(int $index)
   {
       $path = parse_url($this->url)['path'] ?? '';
       $segments = array_values(
           array_filter(
               explode('/', $path),
               function ($value) {
                   return $value !== '';
               }
           )
       );
       return $segments[$index - 1] ?? null;
   }
   /**
    * @param string $prefix
    *
    * @return $this
    */
   public function prefix(string $prefix)
   {
       $this->prefixes[] = $prefix;
       return $this;
   }
}

Menu::macro('addArray', function(array $array, callable $callable){
    foreach($array as $key => $item)
    {
        $this->add($callable($item, $key));
    }
    return $this;
});

Menu::macro('prefixItems', function(string $prefix){
    return $this->applyToAll(function ($item) use ($prefix) {
        $item->prefix($prefix);
    });
});

class Dashboard extends Controller
{
    /**
     * index
     *
     * @method index
     *
     * @return View
     */
    public function index(){

        $collections = collect([
            [
                'link' => '/test',
                'label' => 'Pages'
            ],
            [
                'link' => '/news',
                'label' => 'News'
            ],
        ]);

        Menu::macro('view', function(string $view, $data) {
            $this->html(
                view($view,
                    ['item' => collect(array_merge(
                        $data,
                        [
                            'current_path' => app('request')->path()
                        ]
                    ))]
                )->render()
            );
            return $this;
        });

        // Menu::macro('menu', function(string $menu_class = '') {
        //     return Menu::new()
        //         ->setAttribute('role', 'navigation')
        //         ->addParentClass($menu_class)
        //         ->applyToAll(function (Html $link) {
        //             $link->addParentClass('c-navigation__item o-menu__item');
        //         })
        //         ->applyToAll(function (Link $link) {
        //             $link->addParentClass('c-navigation__item o-menu__item');
        //             $link->addClass('c-navigation__link o-menu__link');
        //         })
        //         ->setActiveClass('is-active')
        //         ->setActiveFromRequest();
        // });

        Menu::macro('menu', function(string $menu_class = '') {
            return Menu::new()->addClass('o-flexbar')
                ->setAttribute('role', 'navigation')
                ->addParentClass($menu_class)
                ->applyToAll(function (Html $link) {
                    $link->addParentClass('o-menu__item');
                })
                ->applyToAll(function (Link $link) {
                    $link->addParentClass('o-menu__item');
                    $link->addClass('o-menu__link');
                })
                ->setActiveClass('is-active')
                ->setActiveFromRequest();
        });

        Menu::macro('sidebar', function() use ($collections) {
            return Menu::menu()->addClass('o-flexbar--vertical o-menu--vertical o-menu--full-width o-menu__body')
                ->prepend(view('menu.header', ['title' => 'Form&System'])->render())
                ->view('menu.item', ['label' => 'Dashboard', 'link' => route('dashboard.index')])
                ->submenu(view('menu.title', ['title' => 'Collections'])->render(),
                    Menu::menu('c-menu__list--dark')->addClass('o-flexbar--vertical o-menu--vertical o-menu--full-width')
                    ->prefixUrls('/collections')
                    ->addArray($collections->toArray(), function($item){
                        $item['icon'] = 'posts';
                        return spatieHTML::make(view('menu.item', [
                            'item'      => collect($item),
                            // ->put('prefix', '/collections'),
                        ])->render(), $item['link']);
                    })
                )
                ->view('menu.item', ['label' => 'Team', 'link' => route('settings.index')])
                ->view('menu.item', ['label' => 'Settings', 'link' => route('settings.index')])
                ->append(view('menu.footer')->render());
        });

        Menu::macro('main', function() use ($collections) {
            return Menu::menu()
            ->submenu(Menu::menu('o-menu__list o-flexbar__item')
                ->view('menu.item', ['icon' => 'projects', 'inline_icon' => true, 'label' => 'Projects', 'link' => '/projects'])
                // ->html('<input type="search" class="box" placeholder="search" />')
            )
            ->submenu(Menu::menu('o-menu__list o-flexbar__item o-flexbar__item--right')->addClass('o-flexbar')
                ->view('menu.item', ['label' => '12', 'link' => '/notifications', 'class' => 'c-menu__link--notifications has-new'])
                ->submenu(Html::raw(view('menu.profile',
                    ['item' => collect(
                        ['icon' => 'projects', 'label' => 'Lukas Oppermann', 'current_path' => app('request')->path(), 'attr' => 'data-js-toggle-dropdown']
                    )]
                )->render()), Menu::menu('o-menu__item')->addClass('o-menu o-menu--vertical o-menu--dropdown c-menu--profile-dropdown o-flexbar o-flexbar--vertical')
                    ->setAttribute('data-js-dropdown')
                    ->view('menu.item', ['label' => 'Profile', 'link' => route('users.me')])
                    ->view('menu.item', ['label' => 'Help', 'link' => route('support.index')])
                    ->view('menu.logout', ['label' => 'Logout', 'link' => '/logout'])
                )
            )
        ;
        });

        return view('dashboard.index');
    }
}
