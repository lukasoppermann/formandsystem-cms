<?php
namespace App\Models\Presenters;

trait UserPresenter
{
    /**
     * returns initals for first and lastname, discards middle names
     * @method getInitialsAttribute
     * @return string
     */
   public function getInitialsAttribute(): string
   {
       $names = collect(explode(' ', $this->name));
        return $names
            ->filter(function($item, $key) use ($names){
                return $key === 0 || $key === ($names->count() - 1);
            })
            ->map(function($item){
                return substr($item,0,1);
            })
            ->implode('');
   }
}
