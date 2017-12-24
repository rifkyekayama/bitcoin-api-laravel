<?php

namespace RifkyEkayama\BitcoinAPI;

use Illuminate\Support\ServiceProvider;

class BitcoinServiceProvider extends ServiceProvider
{
  /**
  * Bootstrap the application services.
  *
  * @return void
  */
  public function boot()
  {
    //
    $this->publishes([
      __DIR__.'/config/bitcoin.php' => config_path().'/bitcoin.php',
      ]);
    }
    
    /**
    * Register the application services.
    *
    * @return void
    */
    public function register()
    {
      //
      $this->registerBitcoin();
      
      $this->app->alias('bitcoin', 'RifkyEkayama\BitcoinBot\Endpoints');
    }
    
    public function registerBitcoin(){
      $this->app->singleton('bitcoin', function (){
        return new Endpoints(config('bitcoin.server_key'), config('bitcoin.secret_key'));
      });
    }
  }
  