<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\User;
use App\Entities\AccountDetail;
use App\Http\Requests;

class Users extends Controller
{
    public function index(){
        return view('dashboard.welcome');
    }
    public function show($user){
        if( $user === 'me' ){
            $user = config('app.user')->get('id');
        }
        // dd('FINISH CREATE IN AbstractEntity at bottom, cache is created, but needs to be added to correct parent as well if created through parent');

        // (new AccountDetail([
        //     'name' => rand(),
        //     'type' => 'fragment',
        // ]));
        // dd((new User($user))->isModelEntity());
        // (new User($user))->account()->attach((new AccountDetail([
        //     'name' => rand(),
        //     'type' => 'fragment',
        // ])));
        // (new User($user))->account()->details()->where('type','fragment')->first()->update([
        //     'name' => 'Test_'.rand()
        // ]);
        // (new User($user))->account()->details()->where('type','fragment')->slice(2,1)->first()->delete();
        // (new User($user))->account()->details()->where('type','fragment')->first()->update([
        //     'name' => rand()
        // ]);
        // (new User($user))->account()->details()->where('type','fragment')->first()->update([
        //     'name' => rand()
        // ]);
        $data = [
            'content' => (new User($user))->account()->details()->where('type','fragment'),
            'navigation' => [
                'header' => [
                    'title' => 'Users',
                    'link' => '/',
                ],
                'lists' => [
                    [
                        'items' => [
                            [
                                'label' => 'Profile',
                                'link'  => '/users/me',
                                'icon'  => 'stack',
                            ],
                        ]
                    ]
                ]
            ]
        ];
        return view('dashboard.welcome', $data);
    }
}
