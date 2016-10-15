<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $favicon=Settings::getSettings()['favicon'];
        $logo=Settings::getSettings()['logo'];
        $parent_categories=Category::getCategoriesByPublish(1,0,1);
        View::share('favicon', $favicon);
        View::share('logo', $logo);
        View::share('parent_categories', $parent_categories);

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
