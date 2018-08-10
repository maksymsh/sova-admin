<?php

namespace Sova\Admin\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Activable
{
    public static function bootActive()
    {
        /*static::addGlobalScope(function (Builder $q){
            return $q->active();
        });*/
    }

    public function scopeActive(Builder $q){
        return $q->where('active', 1);
    }/*

    public function setActiveAttribute($val){
        if($val === 'on') $val = 1;
    }*/
}