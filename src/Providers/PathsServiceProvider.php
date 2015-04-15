<?php
namespace Notetracker\Providers;

use League\Container\ServiceProvider;

class PathsServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        'paths.cache',
        'paths.fixtures',
        'paths.migrations',
        'paths.views',
    ];

    /**
     * @type array
     */
    protected $paths = [
        'cdlc'       => '/Users/anahkiasen/Library/Application Support/Steam/SteamApps/common/Rocksmith2014/dlc/cdlc',
        'cache'      => 'cache',
        'fixtures'   => 'resources/fixtures',
        'migrations' => 'resources/migrations',
        'views'      => 'resources/views',
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->add('paths.base', realpath(__DIR__.'/../..').'/');

        foreach ($this->paths as $key => $relative) {
            $this->container->add('paths.'.$key, function () use ($relative) {
                return substr($relative, 0, 1) === '/' ? $relative : $this->container->get('paths.base').$relative.'/';
            });
        }
    }
}
