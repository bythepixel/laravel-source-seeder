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

        // Publish Package Database Seeders
        $this->publishes([
            __DIR__ . '/SourceSeeder.php' => database_path('seeders/SourceSeeder.php'),
        ], 'laravel-source-seeder');
    }

    /**
     * Register Package Service(s)
     */
    public function register()
    {

    }
}
