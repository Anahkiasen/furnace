<?php
namespace Furnace\Http\Composers;

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

        sort($options);

        $view->tracks = ['' => ''] + $options;
    }
}
