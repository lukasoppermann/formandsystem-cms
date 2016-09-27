<?php

use Spatie\Menu\Laravel\View as ViewItem;
use Spatie\Menu\Laravel\Menu;

function addMenuMacros(){
    // add array of items to menu
    Menu::macro('addArray', function(array $array, callable $callable){
        foreach($array as $key => $item)
        {
            $this->add($callable($item, $key));
        }
        return $this;
    });
    // base menu
    Menu::macro('baseMenu', function(string $menu_class = '', $show = true) {
        return Menu::new()
            // menu settings
            ->addClass('o-flexbar')
            ->setActiveClass('is-active')
            ->setAttribute('role', 'navigation')
            ->addParentClass($menu_class)
            // view settings
            ->applyToAll(function (ViewItem $view) {
                $view->addParentClass('o-menu__item');
            });
    });
}
