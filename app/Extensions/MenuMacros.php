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
    // activate for a path
    ViewItem::macro('activateForPath', function(string $path){
        if(app('request')->path() === trim($path,'/')){
            $this->setActive();
        }

        return $this;
    });
    // view macro
    Menu::macro('view', function(string $view, $data = [], $link = '') {
        $this->add(ViewItem::create($view, $data)->activateForPath($link));

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
            ->applyToAll(function (ViewItem $link) {
                $link->addParentClass('o-menu__item');
            });
    });
}
