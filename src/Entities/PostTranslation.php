<?php

namespace Tir\Post\Entities;

use Tir\Crud\Support\Eloquent\TranslationModel;


class PostTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','body'];
}
