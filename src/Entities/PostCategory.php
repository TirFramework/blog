<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Scaffold\Fields\Number;
use Tir\Crud\Support\Scaffold\Fields\Select;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\User\Entities\User;

class PostCategory extends BaseModel
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // TODO make user_id autoloaded using Auth Facade
    protected $fillable = ['parent_id', 'user_id', 'title', 'slug', 'description', 'image', 'position', 'status',];

    public $timestamps = false;


    protected function setModuleName(): string
    {
        return 'postCategory';
    }

    protected function setFields(): array
    {
        return [
            Text::make('title')->rules('required'),
            Text::make('slug')->rules('required'),
            Text::make('description'),
            Text::make('image'),
            Number::make('position'),
            Select::make('status')->data([
                [
                    'text' => 'Draft',
                    'value' => 0
                ],
                [
                    'text' => 'Published',
                    'value' => 1
                ],
                [
                    'text' => 'UnPublished',
                    'value' => 2
                ]
            ])->default('Draft'),
        ];
    }


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


    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }


}
