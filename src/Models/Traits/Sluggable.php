<?php

namespace Sova\Cms\Models\Traits;

trait Sluggable
{

    public static function bootSluggable(){

    }

    public function getRouteKeyName()
    {
        return parent::getRouteKeyName();
    }

    public function getHumanFriendlyUrl(){
        return url();
    }
}