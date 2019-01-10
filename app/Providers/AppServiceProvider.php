<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

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

            view()->share('best_posts', \App\Post::where([ //nếu bài post có trường post_status = 0 (post rác) và delete_at = 1 (post đã bị xóa)
                ['post_status','=',1],
                ['delete_at','=',0],
                ['view_count', '>=', 1]
            ])->limit(3)->orderBy('view_count', 'desc')->get());
            view()->share('last_posts', \App\Post::where([ //nếu bài post có trường post_status = 0 (post rác) và delete_at = 1 (post đã bị xóa)
                ['post_status','=',1],
                ['delete_at','=',0]
            ])->limit(3)->orderBy('id', 'desc')->get());

            view()->share('tags', \App\Tag::get());

            view()->share('comment_counts', \App\Comment::get());

            view()->share('users', \App\User::get());

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
