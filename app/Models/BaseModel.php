<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    protected $relationshipFilter = [];
    /**
     * Save a new model and return the instance.
     *
     * @param  array  $attributes
     * @return static
     */
    public static function create(array $attributes = [])
    {
        $model = new static($attributes);
        // add uuid
        if( $model->uuid === true ){

            $model->incrementing = false;
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        }
        $model->save();

        return $model;
    }
    /**
     * check if model supports soft deleteing
     *
     * @method isSoftdeleting
     *
     * @return bool
     */
    public function isSoftdeleting(){
        return ($this->forceDeleting === false);
    }
    /**
     * get the fields accepted to be send to model
     *
     * @method acceptedFields
     *
     * @return [array]
     */
    public function acceptedFields(){
        // get mode fields
        $fields = $this->getFillable();
        // remove id
        array_splice($fields, array_search('id', $fields), 1);
        // add soft delete is_trashed
        if($this->isSoftdeleting()){
            $fields[] = 'is_trashed';
        }
        // return fields
        return $fields;
    }
    /**
     * find model including softDeleted
     *
     * @method findWithTrashed
     *
     * @param  [uuid]          $id
     * @param  [bool]          $withTrashed
     *
     * @return [model]
     */
    public function findWithTrashed($id, $withTrashed = true)
    {
        if($this->isSoftdeleting() && $withTrashed === true){
            return $this->withTrashed()->where('id',$id)->first();
        }

        return $this->where('id',$id)->first();
    }
    /**
     * trash or restore from trash
     *
     * @method setTrashed
     *
     * @param  [type]     $model
     * @param  bool       $is_trashed
     */
    public function setTrashed($is_trashed = false){
        if($this->isSoftdeleting()){
            // softDelete if is_trashed is set to true
            if($is_trashed === true){
                $this->delete();
            }
            // restore if is_trashed is set to false
            if($is_trashed === false){
                $this->restore();
            }
        }
    }
    /**
     * return model with trashed items or not
     *
     * @method withTrashed
     *
     * @param  bool       $withTrashed
     */
    public function allWithTrashed($withTrashed = true){
        if($this->isSoftdeleting()){
            // show softDeleted
            if($withTrashed === true){
                $this->withTrashed();
            }
        }
    }
    /**
     * set a relationship filter
     *
     * @method setRelationshipFilter
     *
     * @param  [array]                $array
     */
    public function setRelationshipFilter($array = []){
        $this->relationshipFilter = $array;
    }
    /**
     * retrieve a filter value or a boolean for a compared filter value
     *
     * @method getRelationshipFilter
     *
     * @param  [string]                $filter
     * @param  [mixed]                $value
     *
     * @return [NULL|Mixed|Boolean]
     */
    public function getRelationshipFilter($filter, $value = NULL){
        // return null if $filter is not set
        if(!isset($this->relationshipFilter[$filter])){
            return NULL;
        }
        // return relationshipFilter value of $value is not set
        if($value === NULL){
            return $this->relationshipFilter[$filter];
        }
        // return true or false if value is set
        return ($this->relationshipFilter[$filter] === $value);
    }
    /**
     * return a relationship including with trashed or only trashed if filters are applied
     *
     * @method relWithTrashed
     *
     * @param  [relatioship]         $relationship
     *
     * @return [relatioship]
     */
    protected function relationshipTrashedFilter($relationship){
        // if trashed is requested
        if($this->getRelationshipFilter('with_trashed', true)){
            return $relationship->withTrashed();
        }
        // if onlytrashed is requested
        if($this->getRelationshipFilter('only_trashed', true)){
            return $relationship->onlyTrashed();
        }
        return $relationship;
    }
}
