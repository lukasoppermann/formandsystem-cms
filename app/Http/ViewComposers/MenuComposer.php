<?php

namespace App\Http\ViewComposers;

use Auth;
use Illuminate\View\View;
use Spatie\Menu\Html;
use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\View as ViewItem;

class MenuComposer
{
    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct()
    {
        // load all menu extensions
        Menu::macro('baseMenu', function(string $menu_class = '') {
            return Menu::new()
                // menu settings
                ->addClass('o-flexbar')
                ->setActiveClass('is-active')
                ->addParentClass($menu_class)
                // view settings
                ->applyToAll(function (ViewItem $view) {
                    $view->addParentClass('o-menu__item');
                });
        });
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $view->with([
                'sidebar'       => $this->sidebar(),
                'main_menu'     => $this->mainMenu(),
                'settings_menu' => $this->settingsMenu(),
            ]);
        };
    }
    /**
     * build main sidebar
     * @method sidebar
     */
    protected function sidebar(){
        if(!Auth::user()->currentTeam){
            return false;
        }

        $collections = collect([
            [
                'link' => '/test',
                'label' => 'Replace with DB'
            ],
            [
                'link' => '/news',
                'label' => 'Make icons dynamic'
            ],
        ]);
        return Menu::baseMenu()
            // add menu classes
            ->addClass('o-flexbar--vertical o-menu--vertical o-menu--full-width o-menu__body')
            // add header
            ->prepend(view('menu.header', ['title' => 'Form&System', 'subtitle' => auth()->user()->currentTeam->name])->render())
            // ITEMS
            ->view('menu.item', ['label' => 'Dashboard', 'url' => route('dashboard.index')])
            ->submenu(view('menu.title', ['title' => 'Collections'])->render(),
                Menu::baseMenu('c-menu__list--dark')->addClass('o-flexbar--vertical o-menu--vertical o-menu--full-width')
                ->fill($collections, function($menu, $item){
                    $item['icon'] = 'posts';
                    return $menu->add(ViewItem::create('menu.item', $item)->setUrl($item['link']));
                })
            )
            ->view('menu.item', ['label' => trans('menu.settings'), 'url' => route('teams.settings')])
            // add header
            ->append(view('menu.footer')->render())->setActiveFromRequest();
    }
    /**
     * build main menu
     * @method mainMenu
     */
    protected function mainMenu(){
        return Menu::baseMenu()
        ->submenu(Menu::baseMenu('o-menu__list o-flexbar__item o-flexbar')
            ->addIf(!Auth::user()->currentTeam, HTML::Raw(view('menu.header', ['title' => 'Form&System'])->render()))
            ->view('menu.item', ['icon' => 'projects', 'inline_icon' => true, 'label' => 'Projects', 'url' => route('teams.index')])
        )
        ->submenu(Menu::baseMenu('o-menu__list o-flexbar__item o-flexbar__item--right')->addClass('o-flexbar')
            ->view('menu.item', ['label' => '12', 'link' => '/notifications', 'class' => 'c-menu__link--notifications has-new'])
            ->submenu(ViewItem::create('menu.profile', [
                    'label'         => Auth::user()->name,
                    'initials'      => Auth::user()->initials,
                    'img'           => '',
                    'current_path'  => app('request')->path(),
                    'attr'          => 'data-js-toggle-dropdown',
                ]),
                Menu::baseMenu('o-menu__item')
                    ->addClass('o-menu o-menu--vertical o-menu--dropdown c-menu--profile-dropdown o-flexbar o-flexbar--vertical')
                    ->setAttribute('data-js-dropdown')
                    ->view('menu.item', ['label' => 'Profile', 'url' => route('users.me')], route('users.me'))
                    ->view('menu.item', ['label' => 'Help', 'url' => route('support.index')], route('support.index'))
                    ->view('menu.item', ['label' => 'Logout', 'url' => '/logout'])
            )
        );
    }
    /**
     * settings menu
     * @method settingsMenu
     */
    protected function settingsMenu(){
        return Menu::baseMenu('o-menu')
            ->addIf(!Auth::user()->currentTeam, HTML::Raw(view('menu.header', ['title' => 'Form&System'])->render()))
            ->view('menu.item', ['label' => trans('menu.settings_menu.general'), 'url' => route('teams.settings.project')])
            ->view('menu.item', ['label' => trans('menu.settings_menu.seo'), 'url' => route('teams.settings.seo')])
            ->view('menu.item', ['label' => trans('menu.settings_menu.developers'), 'url' => route('teams.settings.developers')])
            ->view('menu.item', ['label' => trans('menu.settings_menu.team'), 'url' => route('teams.members.show', Auth::user()->currentTeam)])
            ->setActiveFromRequest()
        ;
    }
}
