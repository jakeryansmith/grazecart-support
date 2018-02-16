<?php

namespace App;

use Laravel\Scout\Searchable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use League\HTMLToMarkdown\HtmlConverter;

class ArticleSection extends Model
{
    use Sluggable, Searchable;

    protected $guarded = ['id'];

    protected $table = 'article_sections';

    public function searchableAs()
    {
        return env('APP_ENV').'_ARTICLE_SECTIONS';
    }

    public function toSearchableArray()
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'type' => 'section',
            'url' => $this->url
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
        return (new HtmlConverter())->convert($this->body);
    }

    public function article()
    {
        return $this->belongsTo('App/Article');
    }
}
