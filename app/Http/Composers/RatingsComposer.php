<?php
namespace Furnace\Http\Composers;

use Config;
use Furnace\Entities\Models\Track;
use Illuminate\View\View;

class RatingsComposer
{
    /**
     * @param View $view
     */
    public function composeCreate(View $view)
    {
        $tracks  = Track::with('tracker')->get();
        $options = [];
        foreach ($tracks as $track) {
            $options[$track->id] = sprintf('%s - %s [%s]', $track->artist, $track->name, $track->tracker->name);
        }

        ksort($options);

        $view->tracks     = ['' => ''] + $options;
        $view->plateforms = $this->getPlateforms();
    }

    /**
     * @return array
     */
    protected function getPlateforms()
    {
        $options = [];
        $plateforms = Config::get('furnace.plateforms');
        foreach ($plateforms as $plateform) {
            $options[$plateform] = ucfirst($plateform);
        }

        return $options;
    }
}
