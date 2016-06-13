<?php

namespace App\Services\Api;

class CollectionService extends CacheableApiService
{
    /**
     * all available includes
     *
     * @var array
     */
    protected $includes = [
        'pages',
        'ownedByPages',
        'collections',
        'ownedByCollections',
        'fragments',
        'ownedByFragments',
    ];
    /**
     * the name of the entity
     *
     * @var string
     */
    protected $entity = '\App\Entities\Collection';
    /**
     * the api endpoint to connect to
     *
     * @var string
     */
    protected $endpoint = 'collections';
    /**
     * navigation
     *
     * @method navigation
     *
     * @param  string     $active_collection [description]
     *
     * @return array
     */
    public function navigation($active_collection = NULL)
    {
        if($active_collection !== NULL){
            return (new \App\Services\Api\CollectionService)->find('slug',$active_collection, [
                'only' => 'pages'
            ])->first();
        }
        // if no collection is active
        return [
            'title' => 'Collections',
            'items' => (new \App\Services\Api\CollectionService)->find('type','posts', [
                'only' => false
            ]),
            'template' => 'navigation.collection-item',
        ];
    }
}
