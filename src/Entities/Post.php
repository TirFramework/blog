<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Comment\Entities\Comment;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Eloquent\BaseScaffold;
use Tir\Crud\Support\Eloquent\Translatable;
use Tir\Metadata\Eloquent\HasMetaData;
use Tir\User\Entities\User;

class Post extends BaseModel
{

    use Translatable, Sluggable, HasMetaData;

    /**
     * The attribute show route name
     * and we use in fieldTypes and controllers
     *
     * @var string
     */
    public static $routeName = 'post';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'status','user_id', 'author_id'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'content','summary','images'];


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['translations'];


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
            'title'   => 'required',
            'slug'    => 'required',
            'status'  => 'required',
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
                        'name'    => 'post_information',
                        'type'    => 'tab',
                        'visible' => 'ce',
                        'fields'  => [
                            [
                                'name'    => 'id',
                                'type'    => 'text',
                                'visible' => 'io',
                            ],
                            [
                                'name'    => 'title',
                                'type'    => 'text',
                                'validation' => 'required',
                                'visible' => 'ice',
                            ],
                            [
                                'name'    => 'author_id',
                                'type'    => 'relation',
                                'relation' => ['author', 'name'],
                                'visible' => 'ice',
                            ],
                            [
                                'name'    => 'slug',
                                'type'    => 'text',
                                'validation' => 'required',
                                'visible' => 'ce',
                            ],
                            [
                                'name' => 'categories',
                                'type' => 'relationM',
                                'relation' => ['categories', 'name'],
                                'visible' => 'ice'
                            ],
                            [
                                'name'    => 'summary',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'content',
                                'type'    => 'textEditor',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'created_at',
                                'type'    => 'text',
                                'visible' => 'i',
                            ],
                            [
                                'name'    => 'status',
                                'type'    => 'select',
                                'validation' => 'required',
                                'data'    => ['draft'       => trans('post::panel.draft'),
                                              'published'   => trans('post::panel.published'),
                                              'unpublished' => trans('post::panel.unpublished')
                                ],
                                'visible' => 'icef',
                            ],


                        ]
                    ],
                    [
                        'name'    => 'images',
                        'type'    => 'tab',
                        'visible' => 'ce',
                        'fields'  => [
                            [
                                'name'    => 'images[intro]',
                                'display' => 'intro_image',
                                'type'    => 'image',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'images[main]',
                                'display' => 'main_image',
                                'type'    => 'image',
                                'visible' => 'ce',
                            ]

                        ]
                    ],
                    [
                        'name'    => 'meta',
                        'type'    => 'tab',
                        'visible' => 'ce',
                        'fields'  => [
                            [
                                'name'    => 'meta[meta_title]',
                                'display' => 'meta_title',
                                'type'    => 'text',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[meta_keywords]',
                                'display' => 'meta_keywords',
                                'type'    => 'metaKeywords',
                                'multiple' => true,
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[meta_description]',
                                'display' => 'meta_description',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'meta[meta_custom]',
                                'display' => 'meta_custom',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                        ]
                    ]
                ]
            ]
        ];
    }

    //

    public function getPublishedAtAttribute($value)
    {
        if( config('app.locale') =='fa' ){
            return jdate($value)->format('%H:%M %A %d %B %Y');
        }
        if( config('app.locale') =='en' ){
             return date('M D , Y', strtotime( $value ));

        }
    }

    //Additional methods //////////////////////////////////////////////////////////////////////////////////////////////


    //Relations methods ///////////////////////////////////////////////////////////////////////////////////////////////

    public function categories()
    {
        return $this->belongsToMany(Role::class);
    }

    public function author(){
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
