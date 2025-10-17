<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;

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
        Queue::failing(function (JobFailed $event) {
            Log::error('Queue job failed', [
                'connection' => $event->connectionName,
                'queue'      => $event->job->getQueue(),
                'payload'    => $event->job->payload(),
                'exception'  => $event->exception->getMessage(),
            ]);
        });
    }
}
