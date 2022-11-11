<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Eloquent\IsTranslatable;
use Tir\Crud\Support\Scaffold\Fields\Select;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\Crud\Support\Scaffold\Fields\Editor;
use Tir\Crud\Support\Scaffold\Fields\TextArea;
use Tir\FileManager\Scaffold\Fields\FileUploader;
use Tir\User\Entities\User;

class Post extends BaseModel
{

    use Sluggable;
    use IsTranslatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'author_id',
        'title', 'slug', 'description', 'summary',
        'meta_title', 'meta_description', 'meta_keywords',
        'locale',
        'intro_image', 'main_image',
        'status'];

    protected $casts = [
        'intro_image' => 'array',
        'main_image' => 'array',
    ];


    protected function setModuleName(): string
    {
        return 'post';
    }

    protected function setFields(): array
    {
        return [
            Select::make('locale')->data([
                [
                    'label' => 'fa',
                    'value' => 'fa'
                ],
                [
                    'label' => 'en',
                    'value' => 'en'
                ]
            ])->default('fa')->rules('required')->onlyOnEditing()->readonly()->filter(),
            Select::make('locale')->data([
                [
                    'label' => 'fa',
                    'value' => 'fa'
                ],
                [
                    'label' => 'en',
                    'value' => 'en'
                ]
            ])->default('fa')->rules('required')->hideWhenEditing(),
            Text::make('title')->rules('required')->display(trans('post::panel.title'))->searchable(),
            Text::make('slug')->rules('required')->rules('required', 'unique:posts,slug,' . $this->id)->hideFromIndex(),
            Select::make('categories')->relation('categories', 'title')->multiple()->rules('required'),
            FileUploader::make('intro_image')->maxCount(10)->hideFromIndex(),
            FileUploader::make('main_image')->hideFromIndex(),
            Select::make('author_id')->relation('author', 'name')->rules('required'),
            Editor::make('description')->height(800)->rules('required')->hideFromIndex()->hideFromIndex(),
            TextArea::make('summary')->rules('required')->hideFromIndex(),
            Text::make('meta_title')->hideFromIndex(),
            TextArea::make('meta_description')->hideFromIndex(),
            Text::make('meta_keywords')->hideFromIndex(),
            Select::make('status')->data([
                [
                    'label' => 'Draft',
                    'value' => 'Draft'
                ],
                [
                    'label' => 'Published',
                    'value' => 'Published'
                ],
                [
                    'label' => 'UnPublished',
                    'value' => 'UnPublished'
                ]
            ])->default('Draft')->rules('required')->comment('Post view status')->filter(),
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

    public function categories()
    {
        return $this->belongsToMany(PostCategory::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }


    public function scopeSearch($query, $keywords)
    {
        $query->where('title', 'LIKE', '%' . $keywords . '%');
        return $query;
    }

}
