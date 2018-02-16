<?php

use Faker\Generator as Faker;

$factory->define(\App\ArticleSection::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body' => $faker->paragraph(10)
    ];
});
