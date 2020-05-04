<?php

namespace Munna\Pm;

use Illuminate\Support\ServiceProvider;
use Munna\Pm\PerfectMoney;

class PerfectMoneyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
       
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
       $config = \realpath(__DIR__.'/Config/perfectmoney.php');
       $this->publishes([
            $config => \config_path('perfectmoney.php')
       ]);
       $routes = \realpath(__DIR__.'/Routes/web.php');
       $this->loadRoutesFrom($routes);
       $this->mergeConfigFrom($config, 'perfectmoney');
    }
}
