<?php

namespace Sova\Admin\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Trait Nestable
 * @mixin Model
 * @package Sova\Admin\Models\Traits
 */
trait Nestable
{
    /**
     *
     */
    public static function bootNested(){

    }

    /**
     * @return mixed
     */
    public function parent() {
        return $this->belongsTo(static::class);
    }

    /**
     * @return mixed
     */
    public function children() {
        return $this->hasMany(static::class, 'parent_id');
    }

    /**
     * @param Builder $q
     * @param \Closure|null $callback
     * @return Builder
     */
    public function scopeNested(Builder $q, \Closure $callback = null ) {
        if ($callback) {
            $q = $callback($q);
        }

        return $q->with([ 'children' => function ( Relation $q ) use ( $callback ) {
            return $q->nested($callback);
        } ]);
    }

    /**
     * @param $q
     * @return mixed
     */
    public function scopeRoot(Builder $q){
        return $q->where('parent_id', 0)->orWhereNull('parent_id');
    }
}