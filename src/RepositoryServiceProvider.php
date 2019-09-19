<?php

namespace AnhAiT\LaravelRepository;

use Illuminate\Support\ServiceProvider;
use AnhAiT\LaravelRepository\Console\Commands\RepositoryMakeCommand;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
    	if ($this->app->runningInConsole()) {
	        $this->commands([
	            RepositoryMakeCommand::class,
	        ]);
	    }
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }
}
