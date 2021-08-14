<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Scaffold\Fields\Select;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\User\Entities\User;

class Post extends BaseModel
{

    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug', 'status', 'user_id', 'author_id'];

    protected function setModuleName(): string
    {
        return 'post';
    }

    protected function setFields(): array
    {
        return [
            Text::make('title')->rules('required')->display(trans('post::panel.title')),
            Text::make('body')->rules('required'),
            Select::make('status')->data(['active' => 1, 'deactive' => 0])->rules('required'),
        ];
    }


    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'slug'
            ]
        ];
    }


    public function categories()
    {
        return $this->belongsToMany(PostCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

}
