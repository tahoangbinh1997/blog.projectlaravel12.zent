<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('pagination::view');

        Paginator::defaultSimpleView('pagination::view');
        if(!\App::runningInConsole()){
            view()->share('theloai', \App\Category::get());

            view()->share('best_posts', \App\Post::where('view_count', '>=', 1)->limit(3)->orderBy('view_count', 'desc')->get());
            view()->share('last_posts', \App\Post::limit(3)->orderBy('id', 'desc')->get());

            view()->share('tags', \App\Tag::get());

            view()->share('comment_counts', \App\Comment::get());
        }
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
