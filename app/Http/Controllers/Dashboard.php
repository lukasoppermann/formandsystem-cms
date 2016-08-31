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

        Menu::macro('menu', function(string $menu_class = '') {
            return Menu::new()
                ->setAttribute('role', 'navigation')
                ->addParentClass($menu_class)
                ->applyToAll(function (Html $link) {
                    $link->addParentClass('c-navigation__item o-menu__item');
                })
                ->applyToAll(function (Link $link) {
                    $link->addParentClass('c-navigation__item o-menu__item');
                    $link->addClass('c-navigation__link o-menu__link');
                })
                ->setActiveClass('is-active')
                ->setActiveFromRequest();
        });

        Menu::macro('newMenu', function(string $menu_class = '') {
            return Menu::new()
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
            return Menu::menu()->addClass('c-navigation__body')
                ->prepend(view('menu.header', ['title' => 'Form&System'])->render())
                ->submenu(view('menu.title', ['title' => 'Collections'])->render(),
                    Menu::menu('c-navigation__list c-navigation__list--dark')
                    // ->prefixItems('/collections')
                    ->addArray($collections->toArray(), function($item){
                        return spatieHTML::make(view('menu.item', [
                            'item'      => collect($item),
                            // ->put('prefix', '/collections'),
                        ])->render(), $item['link']);
                    })
                )
                ->route('dashboard.index', 'Dashboard')
                ->route('settings.index', 'Settings')
                ->route('support.index', 'Support')
                ->append(view('menu.footer')->render());
        });

        Menu::macro('main', function() use ($collections) {
            return Menu::new()->addClass('o-menu o-menu--horizontal o-flex-bar')
                // ->html('<input id="flex_bar_toggle" type="checkbox" /><label class="o-flex-bar__hider" for="flex_bar_toggle">Menu</label>
                //         <div class="o-flex-bar o-flex-bar--hideable">
                //             <div class="o-flex-bar__item" style="border: 1px solid red;">Block 1</div>
                //             <div  class="o-flex-bar__item" style="border: 1px solid red;">Block 2</div>
                //             <div  class="o-flex-bar__item" style="border: 1px solid red;">Block 3</div>
                //             <div  class="o-flex-bar__item o-flex-bar__item--right" style="border: 1px solid red;">Block 4</div>
                //             <div  class="o-flex-bar__item" style="border: 1px solid red;">Block 5</div>
                //         </div>
                // ')
            ->submenu(Menu::newMenu('o-menu__list o-flex-bar__item')->addClass('o-flex-bar')
                ->view('menu.newitem', ['icon' => 'projects', 'label' => 'Projects', 'link' => '/projects'])
                ->html('<input type="search" class="box" placeholder="search" />')
            )
            ->submenu(Menu::newMenu('o-menu__list o-flex-bar__item o-flex-bar__item--right')->addClass('o-flex-bar')
                ->html('<input type="search" placeholder="search" />')
                ->html('<input type="search" placeholder="search" />')
            )
        ;
        });

        return view('dashboard.index');
    }
}
