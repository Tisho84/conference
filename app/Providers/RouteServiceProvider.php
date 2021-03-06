<?php

namespace App\Providers;

use App\Department;
use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
        $router->model('users', 'App\User');
        $router->model('categories', 'App\Category');
        $router->model('criteria', 'App\Criteria');
        $router->model('news', 'App\News');
        $router->model('options', 'App\CriteriaOption');
        $router->model('departments', 'App\Department');
        $router->model('types', 'App\UserType');
        $router->model('papers', 'App\Paper');
        $router->model('templates', 'App\EmailTemplate');

        $router->bind('department', function () {
            $department = app()->make('ConferenceBaseController')->getDepartment();
            view()->share('department', $department);
            return $department;
        });
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
