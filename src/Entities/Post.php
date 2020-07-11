<?php

namespace Tir\Post\Entities;

use Astrotomic\Translatable\Translatable;
use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\CrudModel;

class Post extends CrudModel
{

    use Translatable, Sluggable;

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
    protected $fillable = ['title', 'content', 'slug', 'status'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    public $translatedAttributes = ['title', 'body'];


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
            'content' => 'required'
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
                        'name'    => 'menu_information',
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
                                'visible' => 'ice',
                            ],
                            [
                                'name'    => 'slug',
                                'type'    => 'text',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'image',
                                'type'    => 'image',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'intro',
                                'type'    => 'textarea',
                                'visible' => 'ce',
                            ],
                            [
                                'name'    => 'body',
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
                                'data'    => ['draft'       => trans('post::panel.draft'),
                                              'published'   => trans('post::panel.published'),
                                              'unpublished' => trans('post::panel.unpublished')
                                ],
                                'visible' => 'icef',
                            ],


                        ]
                    ]
                ]
            ]
        ];
    }

    //Additional methods //////////////////////////////////////////////////////////////////////////////////////////////

    public function getCreatedAtAttribute($date)
    {
        return jdate($date)->ago();
    }

    public static function urlForPage($id)
    {
        return static::select('slug')->firstOrNew(['id' => $id])->url();
    }

    public function url()
    {
        if (is_null($this->slug)) {
            return '#';
        }

        return '/page/' . $this->slug;

        //TODO:localized url check
        //return localized_url(Crud::locale(), $this->slug);
    }


    //Relations methods ///////////////////////////////////////////////////////////////////////////////////////////////


}
