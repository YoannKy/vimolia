<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use TBMsg;
use Sentinel;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->share('unread', $unread);
        
        
        view()->composer('*', function($view) {
            if(Sentinel::getUser()){
                $view->with('unread', TBMsg::getNumOfUnreadMsgs(Sentinel::getUser()->id));
            }
        });
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
