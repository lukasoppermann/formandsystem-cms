<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Formandsystem\Api\Api;
use App\Services\CacheService;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Entities\User;

use App\Services\Api\CollectionService;
use App\Services\Api\FragmentService;
use App\Services\Api\PageService;

class Test
extends Controller
{
    public function __construct(Request $request)
    {
        config(['app.user' => new User($request->user())]);

        // parent::__construct($request);
    }

    public function index()
    {
        dd(config('app.user')->account()->details());
    }
}
