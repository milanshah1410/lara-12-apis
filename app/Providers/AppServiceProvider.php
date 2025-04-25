<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Support\Facades\Gate;

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
        Schema::defaultStringLength(191);

        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );


            // Exclude security for the login route
            foreach ($openApi->paths as $pathItem) {
                if ($pathItem->path === 'login') {
                    if (isset($pathItem->operations['post'])) {
                        $pathItem->operations['post']->security = [];
                    }
                }
            }

            // Gate::define('viewApiDocs', function () {
            //     return true;
            // });
        });
    }
}
