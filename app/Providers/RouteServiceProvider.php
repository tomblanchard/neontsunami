<?php

namespace NeonTsunami\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'NeonTsunami\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('posts', function ($value, $route) {
            return \NeonTsunami\Post::whereSlug($value)->firstOrFail();
        });

        Route::bind('series', function ($value, $route) {
            return \NeonTsunami\Series::whereSlug($value)->firstOrFail();
        });

        Route::bind('tags', function ($value, $route) {
            return \NeonTsunami\Tag::whereSlug($value)->firstOrFail();
        });

        Route::bind('projects', function ($value, $route) {
            return \NeonTsunami\Project::whereSlug($value)->firstOrFail();
        });

        Route::model('users', \NeonTsunami\User::class);

        parent::boot();
    }


    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();

        $this->mapApiRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
