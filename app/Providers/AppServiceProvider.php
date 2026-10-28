<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

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
        // Student passwords are 4-digit NIS codes, so cap guesses per account. Keyed by
        // name + IP so a whole class logging in from one school network isn't blocked.
        RateLimiter::for('login', function (Request $request) {
            $tooMany = fn () => back()
                ->withErrors(['identity' => 'Terlalu banyak percobaan masuk. Coba lagi dalam 1 menit.'])
                ->onlyInput('identity');

            return [
                Limit::perMinute(5)->by(mb_strtolower((string) $request->input('identity')).'|'.$request->ip())->response($tooMany),
                Limit::perMinute(120)->by('ip:'.$request->ip())->response($tooMany),
            ];
        });
    }
}
