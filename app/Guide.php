<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use League\HTMLToMarkdown\HtmlConverter;

class Guide extends Model
{
    use Sluggable, Searchable;

    protected $guarded = ['id'];

    public function searchableAs()
    {
        return config('scout.algolia.index');
    }

    public function toSearchableArray()
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'type' => 'guide',
            'url' => $this->url,
            'sort_order' => $this->sort_order
        ];
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function markdown($field = 'body')
    {
//        return (new HtmlConverter())->convert($this->{$field});
        return $this->{$field};
    }
}
