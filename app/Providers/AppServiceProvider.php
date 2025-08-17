<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade; // Facade to register custom Blade directives.

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
        // Define @asset('path', [attrs]) which expands to echo App\Helpers\asset_tag(...)
        Blade::directive('asset', function ($expression) {
            // $expression is the raw argument string inside @asset(...)
            // We return PHP code that will be placed into the compiled view.
            return '<?php echo \\App\\Helpers\\asset_tag(' . $expression . '); ?>';
        });
    }
}
