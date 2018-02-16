<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Faq extends Model
{
    use Sluggable, Searchable;

    protected $guarded = ['id'];

    public function searchableAs()
    {
        return 'GC_DOCUMENTATION';
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
}
