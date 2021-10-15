<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ProductRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Repositories\RepositoryInterface',
            'App\Repositories\Repository'
        );
    }
}
