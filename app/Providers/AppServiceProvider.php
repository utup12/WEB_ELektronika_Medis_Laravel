<?php

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        $this->configureDefaults();
        $this->configureRateLimiting();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Configure request limits for public, potentially expensive endpoints.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('ai-chat', function (Request $request): Limit {
            return Limit::perMinute(12)->by(
                'ai-chat:'.($request->user()?->getAuthIdentifier() ?? $request->ip()),
            );
        });

        // Slow down password guessing per account name + IP (OWASP A07).
        RateLimiter::for('local-login', function (Request $request): Limit {
            return Limit::perMinute(5)->by(
                'local-login:'.Str::lower((string) $request->input('name')).'|'.$request->ip(),
            );
        });

        RateLimiter::for('local-register', function (Request $request): Limit {
            return Limit::perMinute(5)->by('local-register:'.$request->ip());
        });

        // Attendance codes are short; stop students from brute-forcing them.
        RateLimiter::for('attendance-code', function (Request $request): Limit {
            return Limit::perMinute(10)->by(
                'attendance-code:'.($request->user()?->getAuthIdentifier() ?? $request->ip()),
            );
        });
    }
}
