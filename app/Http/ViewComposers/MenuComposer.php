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
        addMenuMacros();
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
            ->view('menu.item', ['label' => 'Dashboard', 'link' => route('dashboard.index')])
            ->submenu(view('menu.title', ['title' => 'Collections'])->render(),
                Menu::baseMenu('c-menu__list--dark')->addClass('o-flexbar--vertical o-menu--vertical o-menu--full-width')
                ->prefixUrls('/collections')
                ->addArray($collections->toArray(), function($item){
                    $item['icon'] = 'posts';
                    return ViewItem::create('menu.item', $item)->activateForPath($item['link']);
                })
            )
            ->view('menu.item', ['label' => 'Team', 'link' => route('teams.members.show', Auth::user()->currentTeam)])
            ->view('menu.item', ['label' => trans('menu.settings'), 'link' => route('teams.settings')])
            // add header
            ->append(view('menu.footer')->render());
    }
    /**
     * build main menu
     * @method mainMenu
     */
    protected function mainMenu(){
        return Menu::baseMenu()
        ->submenu(Menu::baseMenu('o-menu__list o-flexbar__item o-flexbar')
            ->addIf(!Auth::user()->currentTeam, HTML::Raw(view('menu.header', ['title' => 'Form&System'])->render()))
            ->view('menu.item', ['icon' => 'projects', 'inline_icon' => true, 'label' => 'Projects', 'link' => route('teams.index')])
        )
        ->submenu(Menu::baseMenu('o-menu__list o-flexbar__item o-flexbar__item--right')->addClass('o-flexbar')
            ->view('menu.item', ['label' => '12', 'link' => '/notifications', 'class' => 'c-menu__link--notifications has-new'])
            ->submenu(ViewItem::create('menu.profile', [
                    'label'         => Auth::user()->name,
                    'initials'      => Auth::user()->initials,
                    'img'           => 'https://s3.amazonaws.com/uifaces/faces/twitter/lukasoppermann/128.jpg',
                    'current_path'  => app('request')->path(),
                    'attr'          => 'data-js-toggle-dropdown',
                ]),
                Menu::baseMenu('o-menu__item')
                    ->addClass('o-menu o-menu--vertical o-menu--dropdown c-menu--profile-dropdown o-flexbar o-flexbar--vertical')
                    ->setAttribute('data-js-dropdown')
                    ->view('menu.item', ['label' => 'Profile', 'link' => route('users.me')], route('users.me'))
                    ->view('menu.item', ['label' => 'Help', 'link' => route('support.index')], route('support.index'))
                    ->view('menu.item', ['label' => 'Logout', 'link' => '/logout'])
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
            ->view('menu.item', ['label' => 'General', 'link' => route('teams.settings', 'site')])
            ->view('menu.item', ['label' => 'SEO', 'link' => route('teams.index')])
            ->view('menu.item', ['label' => 'Developers', 'link' => route('teams.index')])
        ;
    }
}
