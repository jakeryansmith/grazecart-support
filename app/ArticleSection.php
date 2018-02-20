<?php

namespace App;

use Laravel\Scout\Searchable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use League\HTMLToMarkdown\HtmlConverter;

class ArticleSection extends Model
{
    use Sluggable;

    protected $guarded = ['id'];

    protected $table = 'article_sections';

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
            'type' => 'section',
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

    public function markdown()
    {
//        return (new HtmlConverter())->convert($this->body);
        return $this->body;
    }

    public function article()
    {
        return $this->belongsTo('App/Article');
    }
}
