<?php

namespace Sova\Cms\Models\Traits;

use App\Models\Language;
use App\Models\Translation;

trait Translatable
{
    public static function bootTranslatable()
    {

    }

    public function translations(){
        return $this->morphMany(Translation::class, 'ref');
    }

    public function translation(){
        return $this->morphOne(Translation::class, 'ref')->where('lang', app()->getLocale());
    }

    public function getAttribute($key)
    {
        if(app('languages')->first(function($language) use($key) {
            return $language->code == $key;
        })){
            return $this->translate($key);
        }

        if(in_array($key, $this->translatable)){
            $translation = $this->translate();

            if( !empty($translation->$key) )
                return $translation->$key;
            else if ( $translation = $this->translate( settings('main.lang', Language::first()->code) ) )
                return $translation->$key;
        }

        return parent::getAttribute($key);
    }

    public function translate($key = null){

        // if(!$key) $key = settings('main.lang', app()->getLocale());
        if(!$key) $key = app()->getLocale();

        return $this->translations->where('lang', $key)->first();
    }
}