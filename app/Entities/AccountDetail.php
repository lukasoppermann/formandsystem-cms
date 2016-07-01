<?php

namespace App\Entities;

use App\Entities\AbstractModelEntity;
use App\Models\AccountDetail as AccountDetailModel;
use Cache;

class AccountDetail extends AbstractModelEntity
{
    
    /**
     * prepare attributes
     *
     * @method attributes
     *
     * @param  mixed     $source [description]
     *
     * @return array
     */
    protected function attributes($source)
    {
        return $source;
    }
}
