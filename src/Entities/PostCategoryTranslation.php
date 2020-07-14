<?php

namespace Tir\Blog\Entities;

use Tir\Crud\Support\Eloquent\TranslationModel;


class PostCategoryTranslation extends TranslationModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','summary','description'];

    public $table = 'post_category_translations';

}
