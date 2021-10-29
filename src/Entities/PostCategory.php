<?php

namespace Tir\Blog\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Tir\Crud\Support\Eloquent\BaseModel;
use Tir\Crud\Support\Eloquent\IsTranslatable;
use Tir\Crud\Support\Scaffold\Fields\Number;
use Tir\Crud\Support\Scaffold\Fields\Select;
use Tir\Crud\Support\Scaffold\Fields\Text;
use Tir\Crud\Support\Scaffold\Fields\TextArea;
use Tir\User\Entities\User;

class PostCategory extends BaseModel
{
    use Sluggable;
    use IsTranslatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'user_id', 'title', 'slug', 'description', 'image', 'position', 'status', 'locale'];
    public $timestamps = false;


    protected function setModuleName(): string
    {
        return 'postCategory';
    }

    protected function setFields(): array
    {
        return [
            Select::make('locale')->data([
                [
                    'label' => 'Fa',
                    'value' => 'Fa'
                ],
                [
                    'label' => 'En',
                    'value' => 'En'
                ]
            ])->default('Fa')->rules('required')->filter(),
            Select::make('parent_id')->relation('parent','title')->display('parent')->hideFromIndex(),
            Text::make('title')->rules('required'),
            Text::make('slug')->rules('required','unique:post_categories,slug,'.$this->id)->hideFromIndex(),
            // TextArea::make('description')->hideFromIndex(),
            // Text::make('image')->hideFromIndex(),
            Number::make('position'),
            Select::make('status')->data([
                [
                    'label' => 'Draft',
                    'value' => 'Draft'
                ],
                [
                    'label' => 'Unpublished',
                    'value' => 'Unpublished'
                ],
                [
                    'label' => 'Published',
                    'value' => 'Published'
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
