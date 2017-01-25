<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use mjanssen\BreadcrumbsBundle\Breadcrumbs;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composer();
        $this->_topBreakingNews();
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

    public function composer()
    {
        View::composer('layouts.breadcrumbs', function() {

            $data = [
                'global_breadcrumbs' => Breadcrumbs::generate()
            ];

            view()->share($data);
        });
    }

    private function _topBreakingNews()
    {
        $news = DB::table('news')->select('id', 'title')
                    ->where('status', 1)
                    ->where('type', 'news')
                    ->orderBy('published_dt', 'desc')
                    ->limit(5)->get();

        View::share('topbreaking_news', $news);
    }
}
