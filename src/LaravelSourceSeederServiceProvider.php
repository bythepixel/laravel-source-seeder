<?php

namespace LaravelSourceSeeder;

use Illuminate\Support\ServiceProvider;
use LaravelSourceSeeder\Console\Commands\BuildSeederSourceFiles;

class LaravelSourceSeederServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap Package Service(s), which most-notably includes configuring Package Publishing
     */
    public function boot()
    {
        // Publish Package Commands
        if ($this->app->runningInConsole()) {
            $this->commands([BuildSeederSourceFiles::class]);
        }

        $this->publishes([
            __DIR__.'/../config/source-seeder.php' => config_path('source-seeder.php'),
        ]);
    }

    /**
     * Register Package Service(s)
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/source-seeder.php', 'source-seeder'
        );
    }
}
