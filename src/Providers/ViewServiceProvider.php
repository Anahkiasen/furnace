<?php
namespace Notetracker\Providers;

use Illuminate\Support\Str;
use League\Container\ServiceProvider;
use Notetracker\Entities\Models\Track;
use Symfony\Component\Finder\Finder;
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
        ;
        $this->container->singleton(Twig_Environment::class, function () {
            $loader = new Twig_Loader_Filesystem($this->container->get('paths.views'));
            $twig   = new Twig_Environment($loader, [
                'debug'            => true,
                'strict_variables' => false,
                'autoescape'       => false,
            ]);

            $twig->addExtension(new Twig_Extension_Debug());
            foreach ($this->getGlobals() as $name => $global) {
                $twig->addGlobal($name, $global);
            }

            return $twig;
        });
    }

    /**
     * @return array
     */
    protected function getGlobals()
    {
        return [
            'request' => $this->container->get('request'),
            'cdlc'    => $this->getLocalFiles(),
        ];
    }

    /**
     * Get the CDLC in the local files
     *
     * @return string[]
     */
    protected function getLocalFiles()
    {
        // Remove the ones already inserted
        $existing = Track::lists('file');

        // Fetch local files
        $finder = new Finder();
        $cdlc   = $finder->name('*.psarc')->in($this->container->get('paths.cdlc'))->files();
        $cdlc   = array_keys(iterator_to_array($cdlc));
        $cdlc   = array_map('basename', $cdlc);
        $cdlc   = array_diff($cdlc, $existing);

        // Cleanup
        $local = [];
        foreach ($cdlc as $track) {
            $name = str_replace('_m.psarc', null, $track);
            $name = str_replace('_', '-', $name);
            $name = Str::slug($name, ' ');

            $local[$track] = $name;
        }

        ksort($local);

        return $local;
    }
}
