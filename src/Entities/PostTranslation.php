<?php

namespace Tir\Blog\Entities;

use Tir\Crud\Support\Eloquent\TranslationModel;


class PostTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','summary','content','images'];

    protected $casts = [
        'images' => 'array',
        'meta' => 'array'
    ];
}
