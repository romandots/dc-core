<?php
declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider
 * @package App\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     * In addition, it is set as the URL generator's root namespace.
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define the routes for the application.
     * @return void
     */
    public function map(): void
    {
        $this->mapApiRoutes();
//        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     * These routes all receive session state, CSRF protection, etc.
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     * These routes are typically stateless.
     * @return void
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('')
            ->namespace($this->namespace . '\Auth')
            ->group(base_path('routes/auth.php'));

        Route::prefix('')
            ->middleware('api')
            ->namespace($this->namespace . '\PublicApi')
            ->group(base_path('routes/public_api.php'));

        Route::prefix('admin')
            ->middleware('manager_api')
            ->namespace($this->namespace . '\ManagerApi')
            ->group(base_path('routes/admin_api.php'));

        Route::prefix('student')
            ->middleware('student_api')
            ->namespace($this->namespace . '\StudentApi')
            ->group(base_path('routes/student_api.php'));

        Route::prefix('instructor')
            ->middleware('instructor_api')
            ->namespace($this->namespace . '\InstructorApi')
            ->group(base_path('routes/instructor_api.php'));
    }
}
