<?php

namespace App\Entities;

use App\Entities\AbstractModelEntity;
use Cache;

class AccountDetail extends AbstractModelEntity
{
    /**
     * model namespace or model instance
     *
     * @var string|Model
     */
    protected $model = '\App\Models\AccountDetail';
    /**
     * prepare attributes
     *
     * @method attributes
     *
     * @param  mixed     $source [description]
     *
     * @return array
     */
     protected function attributes($model)
     {
         return $model->toArray();
     }
}
