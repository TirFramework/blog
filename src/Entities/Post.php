<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
<<<<<<< HEAD
=======
use Tir\Crud\Support\Scaffold\Fields\Relation;
>>>>>>> b8dfe46a456326ec45f3d29a7087946f38dea896
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
<<<<<<< HEAD
            Select::make('status')->data(['active' => 1, 'deactive' => 0])->rules('required'),
=======
            Select::make('category_id')->relation('categories','title')
>>>>>>> b8dfe46a456326ec45f3d29a7087946f38dea896
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
