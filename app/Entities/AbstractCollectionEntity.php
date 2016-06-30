<?php

namespace App\Entities;

use App\Entities\AbstractEntity;
use Illuminate\Support\Collection;

abstract class AbstractCollectionEntity extends AbstractEntity
{
    /**
     * get id for current entity from source
     *
     * @method getId
     *
     * @return string
     */
    protected function getId($source = NULL)
    {
        if($source === NULL && !isset($this->source)){
            return FALSE;
        }

        if($source === NULL){
            $source = $this->source;
        }

        return $source->get('id');
    }
    /**
     * return current entities source as array
     *
     * @method getSourceArray
     *
     * @param Illuminate\Support\Collection $source [description]
     *
     * @return Array
     */
    protected function getSourceArray($source)
    {
        return $source->toArray();
    }
    /**
     * return current entities source from cache, db or api, etc.
     *
     * @method getSource
     *
     * @param  [type]    $source [description]
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    protected function getSource($source)
    {
        // if source is not a model
        if(!is_a($source, 'Illuminate\Support\Collection')){
            return $this->getData($source);
        }
        // return source
        return $source;
    }
    /**
     * validate data before update
     */
    abstract protected function validateUpdate(Array $data);
    /**
     * validate data before create
     */
    abstract protected function validateCreate(Array $data);
    /**
     * get data for given $id
     */
    abstract protected function getData($id);
}
