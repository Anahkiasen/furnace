<?php
namespace Furnace\Http\Composers;

use Config;
use Illuminate\View\View;

class RatingsComposer
{
    /**
     * @param View $view
     */
    public function composeCreate(View $view)
    {
        $view->platforms = $this->getPlatforms();
    }

    /**
     * @return array
     */
    protected function getPlatforms()
    {
        $options    = [];
        $platforms = Config::get('furnace.platforms');
        foreach ($platforms as $platform) {
            $options[$platform] = array_get([
                'ps' => 'Playstation',
                'pc' => 'PC',
            ], $platform, ucfirst($platform));
        }

        return $options;
    }
}
