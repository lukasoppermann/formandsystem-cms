<?php

namespace App\Extensions;

use Spatie\Menu\HasUrl;
use Spatie\Menu\Laravel\View as View;
use Spatie\Menu\Traits\HasUrl as HasUrlTrait;

class ViewItem extends View implements HasUrl
{
    use HasUrlTrait;

    protected $url;
}
