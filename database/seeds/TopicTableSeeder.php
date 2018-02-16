<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Topic::class, 10)->create()->each(function ($topic) {
            factory(App\Article::class, 5)->create(['topic_id' => $topic->id])->each(function ($article) use ($topic) {
                $topic->articles()->save($article);
                factory(App\ArticleSection::class, 3)->create(['article_id' => $article->id])->each(function ($section) use ($article) {
                    $article->sections()->save($section);
                });
            });
        });
    }
}
