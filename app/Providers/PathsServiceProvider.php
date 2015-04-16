<?php
namespace Furnace\Providers;

use Illuminate\Support\ServiceProvider;

class PathsServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $paths = [
        'cdlc'       => '/Users/anahkiasen/Library/Application Support/Steam/SteamApps/common/Rocksmith2014/dlc/cdlc',
        'fixtures'   => 'database/fixtures',
        'views'      => 'resources/views',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        foreach ($this->paths as $key => $relative) {
            $this->app->bind('paths.'.$key, function () use ($relative) {
                return substr($relative, 0, 1) === '/' ? $relative : base_path($relative.'/');
            });
        }
    }
}
