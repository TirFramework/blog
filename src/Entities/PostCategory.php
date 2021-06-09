<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Scopes\OwnerScope;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\Crud\Support\Scaffold\Fields\Textarea;
use Tir\User\Entities\User;

class PostCategory extends BaseModel
{

//    use Translatable, Sluggable;
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'parent_id', 'images', 'position', 'status', 'user_id'];

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
//    public $translatedAttributes = ['name', 'summary', 'description', 'meta'];


    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
//    protected $with = ['translations'];

    public $timestamps = false;


    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }

    protected $casts = [
        'images' => 'array'
    ];

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

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new OwnerScope);
    }


    //Additional methods //////////////////////////////////////////////////////////////////////////////////////////////
    public function parent()
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        // return PostCategoryTranslation::class;
        return $this->belongsToMany(Post::class);
    }


    //Relations methods ///////////////////////////////////////////////////////////////////////////////////////////////

    public bool $localization = false;


    protected function setModel()
    {
        return $this;
    }

    protected function setModuleName(): string
    {
        return 'postCategory';
    }

    protected function setFields(): array
    {
        return [
            Text::make('title')->rules('required'),
            Textarea::make('desctiption')->rules('required'),
        ];
    }
}
