<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Scaffold\Fields\Number;
use Tir\Crud\Support\Scaffold\Fields\Select;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\Crud\Support\Scaffold\Fields\TextArea;
use Tir\User\Entities\User;

class PostCategory extends BaseModel
{
    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'user_id', 'title', 'slug', 'description', 'image', 'position', 'status'];

    public $timestamps = false;


    protected function setModuleName(): string
    {
        return 'postCategory';
    }

    protected function setFields(): array
    {
        return [
            Select::make('parent_id')->relation('parent','title')->display('parent'),
            Text::make('title')->rules('required'),
            Text::make('slug')->rules('required','unique:post_categories,slug,'.$this->id),
            TextArea::make('description'),
            Text::make('image'),
            Number::make('position'),
            Select::make('status')->data([
                [
                    'label' => 'Draft',
                    'value' => 0
                ],
                [
                    'label' => 'Unpublished',
                    'value' => 1
                ],
                [
                    'label' => 'Published',
                    'value' => 2
                ],
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
