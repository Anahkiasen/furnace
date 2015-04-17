<?php
namespace Furnace\Http\Composers;

use Furnace\Entities\Models\Track;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\Finder\Finder;

class TracksComposer
{
    /**
     * @type Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $view->cdlc = $this->getLocalFiles();
    }

    /**
     * Get the CDLC in the local files.
     *
     * @return string[]
     */
    protected function getLocalFiles()
    {
        // Remove the ones already inserted
        $existing = Track::lists('file');

        // Fetch local files
        $finder = new Finder();
        $cdlc   = $finder->name('*.psarc')->in($this->container->make('paths.cdlc'))->files();
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
