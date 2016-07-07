<?php

namespace App\Providers;

use Tzookb\TBMsg\TBMsgServiceProvider as TBMsgServiceProvider;
use App\Repositories\Tbmsg\CustomEloquentTBMsgRepository as CustomEloquentTBMsgRepository;
use Config;
use App\Vendors\CustomTBMsg;

class CustomTBMsgServiceProvider extends TBMsgServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $usersTable = Config::get('tbmsg.usersTable', 'users');
        $usersTableKey = Config::get('tbmsg.usersTableKey', 'id');
        $tablePrefix = Config::get('tbmsg.tablePrefix', '');

        $this->app->bind(
            'App\Repositories\TBMsg\Contracts\iTBMsgRepository',
            function ($app) use ($tablePrefix, $usersTable, $usersTableKey) {
                $db = $app->make('Illuminate\Database\DatabaseManager');
                return new CustomEloquentTBMsgRepository($tablePrefix, $usersTable, $usersTableKey, $db);
            }
        );

        // Register 'tbmsg'
        $this->app['tbmsg'] = $this->app->share(function ($app) {
            return new CustomTBMsg(
                $app['App\Repositories\TBMsg\Contracts\iTBMsgRepository'],
                $app['Illuminate\Contracts\Events\Dispatcher'] //Illuminate\Events\Dispatcher
            );
        });
    }
}
