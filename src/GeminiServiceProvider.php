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
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'gemini');

        $this->app->singleton('gemini', function () {
            $gemini = new Gemini(Config::get('gemini.API_KEY_GEMINI'));
            $gemini->setDefaultModel(Config::get('gemini.DEFAULT_MODEL', 'gemini-1.5-flash'));
            $gemini->timeout = (float) Config::get('gemini.TIMEOUT', 30);

            return $gemini;
        });
    }
}