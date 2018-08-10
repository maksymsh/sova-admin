<?php

namespace Sova\Cms\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Sortable
{
    public static function bootSortable()
    {
        /*static::addGlobalScope(function (Builder $q){
            return $q->ordered();
        });*/
    }

    public function scopeOrdered(Builder $q){
        return $q->orderBy('sort_order');
    }
}