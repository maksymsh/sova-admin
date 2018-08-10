<?php

namespace Sova\Admin\Models;

use Sova\Admin\Models\Traits\Translatable;
use Sova\Admin\Models\Traits\Mediable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\UploadedFile;
use Route;

/**
 * Class MasterModel
 * @inheritdoc
 * @package App\Models
 */
class MasterModel extends Model
{

    protected $connection = 'admin';

    protected $relationsToSave = [];
    protected $filesToSave = [];
    protected $translationsToSave = [];

    public static function boot()
    {
        parent::boot();
    }

    public function fill(array $attributes)
    {
        /** @var $model MasterModel */
        $model = parent::fill(array_only($attributes, $this->fillable));

        foreach ($attributes as $key => $value) {
            if($model->uses(Translatable::class) && app('languages')->first(function($language) use($key) {
                return $language->code == $key;
            })){
                $this->translationsToSave[$key] = $value;
            }


            if(!in_array($key, ['save']) && method_exists($this, $key)){
                $relation = $model->$key();

                if($relation instanceof Relation) {
                    $this->relationsToSave[$key] = [$relation, $value];
                }
            } elseif($model->uses(Mediable::class) && ($value instanceof UploadedFile || (is_array($value) && $value[array_keys($value)[0]] instanceof UploadedFile))){
                if($value instanceof UploadedFile)
                    $value = [$value];
                $this->filesToSave[$key] = $value;
            }

            if($model->uses(Mediable::class)){
                //todo: save media

            }

        }

        return $model;
    }

    public function save(array $options = [])
    {
        if($this->relationsToSave || $this->translationsToSave || $this->filesToSave){
            try{
                \DB::beginTransaction();

                $saved = parent::save($options);

                $relationsToSave = $this->relationsToSave;
                $this->relationsToSave = [];

                foreach ($relationsToSave as $key => $rel) {
                    $relation = $rel[0];
                    $data = $rel[1];

                    if($relation instanceof HasOneOrMany){
                        $relation_ids = array_filter(array_pluck($data ?: [], 'id'));

                        foreach ($data ?: [] as $i => $datum) {
                            if(isset($datum['id']) && $datum['id']){
                                $related = $relation->getRelated()->where('id', $datum['id'])->first();
                                if($related){
                                    $related->update($datum);
                                    unset($data[$i]);
                                }
                            }
                        }

                        $relation->whereNotIn('id', $relation_ids)->delete();

                        if($data !== null){
                            if($relation instanceof HasOne)
                                $relation->create($data);
                            else
                                $relation->createMany($data);
                        }
                    } elseif($relation instanceof BelongsToMany){
                        $relation->sync([]);
                        if($data !== null && is_array($data)){
                            $relation->sync($data);
                        }
                    }
                }

                $translations = [];

                $translationsToSave = $this->translationsToSave;
                $this->translationsToSave = [];

                foreach ($translationsToSave as $lang => $data) {
                    $data['lang'] = $lang;
                    $translations[] = $data;
                }

                if($translations){
                    $relation = $this->translations();
                    $relation->delete();
                    $relation->createMany($translations);
                }

                $filesToSave = $this->filesToSave;
                $this->filesToSave = [];

                foreach ($filesToSave as $collection => $files) {
                    foreach ($files as $file) {
                        if($file instanceof UploadedFile){
                            //todo: save media
                        }
                    }
                }

                \DB::commit();
            } catch (\Exception $e){
                \DB::rollBack();
                throw $e;
            }
        } else {
            $saved = parent::save($options);
        }

        return $saved;
    }

    public static function abstract(array $array){
        $model = new self();
        foreach ($array as $key => $value) {
            if(is_array($value)){
                if(is_array(array_first($value))){
                    $value = array_map(function ($item){
                        $value = self::abstract($item);
                        $value->pivot = $value;
                        return $value;
                    }, $value);
                } else {
                    $value = self::abstract($value);
                    $value->pivot = $value;
                }
            }
            $model->$key = $value;
            $model->pivot = $model;
        }
        return $model;
    }

    public function uses($trait = null)
    {
        return $trait ? in_array($trait, class_uses($this)) : class_uses($this);
    }

}
