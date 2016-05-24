<?php

namespace App\Providers;

use App\Department;
use App\Http\Controllers\ConferenceBaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('ConferenceBaseController', function () {
            return new ConferenceBaseController();
        });

        $departmentsSelect = getNomenclatureSelect(Department::with(['langs' => function($query){
            $query->lang();
        }])->sort()->active()->get(), true);

        view()->share('departmentsSelect', $departmentsSelect);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
        }
    }
}
