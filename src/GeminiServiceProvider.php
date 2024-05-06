<?php
 
namespace Faiznurullah\Gemini;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;

class GeminiServiceProvider extends ServiceProvider
{

    public function boot()
    {
          
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . './config/config.php', 'gemini');

        $this->app->singleton('gemini', function () {
            return new Gemini(Config::get('gemini.API_KEY_GEMINI'));
        });
    }
}