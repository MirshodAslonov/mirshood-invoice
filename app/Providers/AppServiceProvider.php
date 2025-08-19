<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Contracts\ClientRepositoryInterface::class,
            \App\Repositories\Eloquent\ClientRepository::class
        );
        $this->app->bind(
            \App\Repositories\Contracts\InvoiceRepositoryInterface::class,
            \App\Repositories\Eloquent\InvoiceRepository::class
        );
        $this->app->bind(
            \App\Services\Auth\Contracts\AuthServiceInterface::class,
            \App\Services\Auth\AuthService::class
        );

        // PDF Strategy: hozircha DomPDF
        $this->app->bind(
            \App\Services\Invoice\Contracts\PdfGeneratorInterface::class,
            \App\Services\Invoice\Pdf\DompdfGenerator::class
        );

        // Telegram SDK
        $this->app->singleton(Api::class, function () {
            return new Api(config('services.telegram.bot_token'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
