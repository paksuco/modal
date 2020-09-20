<?php

namespace Paksuco\Modal;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class ModalServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleConfigs();
        $this->handleViews();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Bind any implementations.
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function handleConfigs()
    {
        $configPath = __DIR__ . '/../config/paksuco-modal.php';
        $this->publishes([$configPath => base_path('config/paksuco-modal.php')]);
        $this->mergeConfigFrom($configPath, 'paksuco-modal');
    }

    private function handleViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../views', 'paksuco-modal');
        $this->publishes([__DIR__.'/../views' => base_path('resources/views/vendor/paksuco-modal')]);

        Livewire::component("paksuco-modal::modal", \Paksuco\Modal\Components\Modal::class);
        $this->loadViewComponentsAs("paksuco-modal", [
            Components\Alert::class
        ]);
    }
}

if (!function_exists("base_path")) {
    function base_path($path)
    {
        return \Illuminate\Support\Facades\App::basePath($path);
    }
}
