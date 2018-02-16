<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use Sluggable;
    protected $guarded = ['id'];

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

    public function articles() {
        return $this->hasMany('App\Article')
            ->where('visible', true)
            ->orderBy('sort_order');
    }
}
