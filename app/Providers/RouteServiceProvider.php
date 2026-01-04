<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip())->response(function (Request $request, array $headers) {
                return response('Too many login attempts. Please try again in a minute.', 429);
            });
        });
        // RateLimiter::for('login-apps', function (Request $request) {
        //     return Limit::perMinute(3)->by(optional($request->user())->id ?: $request->ip())->response(function () {
        //         return response(['messsage' => 'You have reached your access limit (Posts). Please try after 1 minute.'], 429);
        //     });
        // });
        RateLimiter::for('login-apps', function(Request $request){
            $key = 'login-apps.'.$request->ip();
            $max = 3;
            $decay = 60;
            if (RateLimiter::tooManyAttempts($key,$max)) {
                return redirect()->back()->with('message','Too Many Request.');
            }else{
                RateLimiter::hit($key,$decay);
            }
        });
    }
}
