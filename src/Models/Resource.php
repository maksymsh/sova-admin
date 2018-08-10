<?php

namespace Sova\Admin\Models;

class Resource extends MasterModel
{
    protected $fillable = ['name', 'traits', 'data', 'fields'];

    protected $casts = [
        'traits' => 'array',
        'data' => 'array',
        'fields' => 'collection',
    ];


}