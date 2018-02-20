<?php

namespace App\Providers;

use App\Parsers\VideoParser;
use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
