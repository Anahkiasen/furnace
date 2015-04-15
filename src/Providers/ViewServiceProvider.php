<?php
namespace Notetracker\Providers;

use League\Container\ServiceProvider;
use Notetracker\Models\Track;
use Twig_Environment;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * @type array
     */
    protected $provides = [
        Twig_Environment::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->singleton(Twig_Environment::class, function () {
            $loader = new Twig_Loader_Filesystem($this->container->get('paths.views'));
            $twig   = new Twig_Environment($loader, [
                'debug'            => true,
                'strict_variables' => false,
                'autoescape'       => false,
            ]);

            $twig->addExtension(new Twig_Extension_Debug());
            $twig->addGlobal('request', $this->container->get('request'));
            $twig->addGlobal('rating_scale', Track::RATING_SCALE);

            return $twig;
        });
    }
}
