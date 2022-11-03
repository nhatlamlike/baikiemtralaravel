<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductType as ModelsProductType;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use ProductType;

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
        view()->composer('banhang.layout.header',function($view){
            $loai_sp = ModelsProductType::all();
            $view ->with('loai_sp', $loai_sp);
        });

        // view()->composer('banhang.checkout',function($view){
        //     $products = Product::all();
        //     $view ->with('products', $products);
        // });

        
        view()->composer(['banhang.layout.header', 'banhang.checkout'], function($view){
            if(Session('cart')){
                $oldCart = Session::get('cart');
                $cart = new Cart($oldCart);
                $products = Product::all();
                $view->with(['cart'=>Session::get('cart'), 'product_cart'=>$cart->items, 'products'=>$products, 'totalPrice'=>$cart->totalPrice,
            'totalQty'=>$cart->totalQty]);
            }  
        });

        // view()->composer('header',function($view){

        // })
        Paginator::useBootstrapFour();
    }
}
