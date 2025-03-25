<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
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
        if (app()->runningInConsole()) {
            // ตรวจสอบว่าแอปกำลังทำงานในโหมด Local หรือไม่
            if (app()->isLocal()) {
                // เรียกคำสั่ง 'tour:check-dates' ทุกครั้งที่รัน php artisan serve
                \Artisan::call('app:check-tour-dates');
            }
        }
    }
}
