<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Product;

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
    public function boot()
    {
        view()->composer('*',function($view) {
        $min_price = Product::min('product_price');
        $max_price = Product::max('product_price');
        
       

        $view->with('min_price',$min_price)->with('max_price',$max_price);
        });
    }
}
