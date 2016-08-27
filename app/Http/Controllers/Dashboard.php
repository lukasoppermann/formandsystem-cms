<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Menu\Html;
use Spatie\Menu\Laravel\Menu;

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
        Menu::macro('main', function() {
            return Menu::new()
                ->submenu(view('menu.title', ['title' => 'Collections'])->render(), Menu::new([

                    ])
                )
                ->submenu(Menu::new()
                    ->route('dashboard.index', 'Dashboard')
                    ->route('settings.index', 'Settings')
                    ->route('support.index', 'Support')
                );
        });

        return view('dashboard.index');
    }
}
