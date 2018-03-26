<?php

namespace App;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class ArticleSection extends Model
{
    use Sluggable, Searchable;

    protected $guarded = ['id'];

    protected $table = 'article_sections';

    public function searchableAs()
    {
        return config('scout.algolia.index');
    }

    public function getScoutKey()
    {
        return 'article_section:'.$this->id;
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

    /**
     * Return the article the section belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function article()
    {
        return $this->belongsTo('App/Article');
    }
}
