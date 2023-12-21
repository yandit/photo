<?php

namespace Modules\GoogleDriveMedia\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\Config;
use Modules\GoogleDriveMedia\Entities\Disk;

class GoogleDriveMediaServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'GoogleDriveMedia';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'googledrivemedia';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));

        try {
            $disks = $this->disks();
            foreach ($disks as $key => $disk) {
                \Storage::extend($disk->disk_name, function($app, $config) {
                    return $this->createGoogleDriveAdapter($config);
                });
            }
        } catch(\Exception $e) {
            
        }
    }

    protected function createGoogleDriveAdapter($config)
    {
        $options = [];
        
        if (!empty($config['teamDriveId'] ?? null)) {
            $options['teamDriveId'] = $config['teamDriveId'];
        }

        if (!empty($config['sharedFolderId'] ?? null)) {
            $options['sharedFolderId'] = $config['sharedFolderId'];
        }

        $client = new \Google\Client();
        $client->setClientId($config['clientId']);
        $client->setClientSecret($config['clientSecret']);
        $client->refreshToken($config['refreshToken']);
        
        $service = new \Google\Service\Drive($client);
        $adapter = new \Masbug\Flysystem\GoogleDriveAdapter($service, $config['folder'] ?? '/', $options);
        $driver = new \League\Flysystem\Filesystem($adapter);

        return new \Illuminate\Filesystem\FilesystemAdapter($driver, $adapter);
    }

    protected function disks()
    {
        $disks = Disk::all();
        return $disks;
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        // register disk dari tabel disks
        $disks = $this->disks();
        foreach ($disks as $key => $disk) {
            Config::set("filesystems.disks.{$disk->disk_name}", [
                'driver' => 'google',
                'clientId' => $disk->client_id,
                'clientSecret' => $disk->client_secret,
                'refreshToken' => $disk->refresh_token,
                'folder' => '',
            ]);
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );

        $this->publishes([
            module_path($this->moduleName, 'Config/menus.php') => config_path('menus.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/menus.php'), 'menus'
        );

        $this->publishes([
            module_path($this->moduleName, 'Config/permissions.php') => config_path('permissions.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/permissions.php'), 'permissions'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        } else {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
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

    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach (\Config::get('view.paths') as $path) {
            if (is_dir($path . '/modules/' . $this->moduleNameLower)) {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
