<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use Auth;
use App\Type;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        //
        // Set the app locale according to the URL
        app()->setLocale($request->segment(1));

        Schema::defaultStringLength(191);
        // View::share('name', 'Vaidas');
        View::composer('*', function($view) {
            $view->with('userData', Auth::user());
        });

         // View::share('type_all_pages', 'women');
        View::composer('*', function($view) {
            $type_all_pages = Type::where('is_active', 1)->first();
            $view->with('type_all_pages', $type_all_pages->type);
        });


        //show view name vj koregavimas
        view()->composer('*', function($view){
            $view_name = str_replace('.', '-', $view->getName());
            view()->share('view_name', $view_name);
        });



    }
}
