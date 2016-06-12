<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Formandsystem\Api\Api;
use App\Services\CacheService;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Services\Api\CollectionService;
use App\Services\Api\FragmentService;
use App\Services\Api\PageService;

class Test extends Controller
{
    protected $start = 0;
    protected $milliseconds = 0;

    public function __construct(Request $request)
    {
        $this->start = round(microtime(true) * 1000);
        parent::__construct($request);
    }

    public function index()
    {
        $this->time('Index');
        $pages = [];
        // return new API instance
        // \Log::debug('Collections: '.$collections->count());
        //
        // $fragments = (new FragmentService)->all();
        // \Log::debug('Fragments: '.$fragments->count());
        dd((new CollectionService)->find('slug','yo'));
        // $pages = (new CollectionService)->all(['includes' =>[
        //     'pages',
        //     ]
        // ]);
        // \Log::debug('Pages: '.$pages->count());

        $this->time('API Call');

        echo "Overall: ".(round(microtime(true) * 1000) - $this->start).'ms<br />';

        // dd($pages);
    }

    public function time($label = 'Test')
    {
        if($this->milliseconds === 0){
            $this->milliseconds = round(microtime(true) * 1000);
        }
        echo $label.': '.(round(microtime(true) * 1000) - $this->milliseconds).'ms<br />';
        $this->milliseconds = round(microtime(true) * 1000);
    }
}
