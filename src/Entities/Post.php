<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Scaffold\Fields\Select;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\Crud\Support\Scaffold\Fields\TextArea;
use Tir\User\Entities\User;

class Post extends BaseModel
{

    use Sluggable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [
        'user_id', 'author_id', 'post_category_id',
        'title', 'slug', 'description', 'summary',
        'meta_title', 'meta_description', 'meta_keywords',
        'thumb_image', 'full_image',
        'status'];


    protected function setModuleName(): string
    {
        return 'post';
    }

    protected function setFields(): array
    {
        return [
            Text::make('title')->rules('required')->display(trans('post::panel.title')),
            Text::make('slug')->rules('required'),
            TextArea::make('description')->rules('required'),
            TextArea::make('summary')->rules('required'),
            Text::make('meta_title'),
            TextArea::make('meta_description'),
            Text::make('meta_keywords'),
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
            ])->default('Draft')->rules('required'),
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
