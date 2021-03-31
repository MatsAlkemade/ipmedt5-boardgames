<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use App\Http\Controllers\GameStateController;
use \Symfony\Component\Console\Output\ConsoleOutput;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->gsc = new GameStateController("Hier moet iets in");
        // (new ConsoleOutput())->writeln("GameStateController singleton");
        // (new ConsoleOutput())->writeln("test");
        // $this->app->singleton(GameStateController::class, function ($app) {
            // return $app->gsc;
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('svg', function($arguments) {
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");

            // Create the dom document as per the other answers
            $svg = new \DOMDocument();
            $svg->load(public_path($path));
            $svg->documentElement->setAttribute("class", $class);
            $output = $svg->saveXML($svg->documentElement);

            return $output;
        });
    }
}
