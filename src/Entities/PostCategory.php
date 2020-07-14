<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\CrudModel;
use Tir\Crud\Support\Eloquent\Translatable;

class PostCategory extends CrudModel
{

    use Translatable, Sluggable;

    /**
     * The attribute show route name
     * and we use in fieldTypes and controllers
     *
     * @var string
     */
    public static $routeName = 'postCategory';

    public $table = 'post_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'parent_id', 'images', 'position', 'status','user_id'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'summary', 'description', 'meta_description'];


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];

    public $timestamps = false;


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    /**
     * This function return array for validation
     *
     * @return array
     */
    public function getValidation()
    {
        return [
            'name'   => 'required',
            'slug'   => 'required',
            'status' => 'required',
        ];
    }


    /**
     * This function return an object of field
     * and we use this for generate admin panel page
     * @return array
     */
    public function getFields()
    {
        return [
            [
                'name'    => 'basic_information',
                'type'    => 'group',
                'visible' => 'ce',
                'tabs'    => [
                    [
                        'name'    => 'postCategory_information',
                        'type'    => 'tab',
                        'visible' => 'ce',
                        'fields'  => [
                            [
                                'name'    => 'id',
                                'type'    => 'text',
                                'visible' => 'io',
                            ],
                            [
                                'name'    => 'name',
                                'type'    => 'text',
                                'visible' => 'ice',
                            ],
                            [
                                'name'    => 'slug',
                                'type'    => 'text',
                                'visible' => 'ce',
                            ],
                            [
                                'name'     => 'parent_id',
                                'type'     => 'relation',
                                'relation' => ['parent','name'],
                                'visible'  => 'ce',
                            ],
                            [
                                'name'    => 'images',
                                'type'    => 'image',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'summary',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'description',
                                'type'    => 'textEditor',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'status',
                                'type'    => 'select',
                                'data'    => ['draft'       => trans('post::panel.draft'),
                                              'published'   => trans('post::panel.published'),
                                              'unpublished' => trans('post::panel.unpublished')
                                ],
                                'visible' => 'cef',
                            ],
                            [
                                'name' => 'meta',
                                'type' => 'metaDescription',
                                'visible' => 'ce'

                            ]


                        ]
                    ]
                ]
            ]
        ];
    }

    //Additional methods //////////////////////////////////////////////////////////////////////////////////////////////
    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    public function posts()
    {
        return PostCategoryTranslation::class;
        return $this->hasMany(Post::class);
    }



    //Relations methods ///////////////////////////////////////////////////////////////////////////////////////////////


}
