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
        $view->plateforms = $this->getPlateforms();
    }

    /**
     * @return array
     */
    protected function getPlateforms()
    {
        $options    = [];
        $plateforms = Config::get('furnace.plateforms');
        foreach ($plateforms as $plateform) {
            $options[$plateform] = ucfirst($plateform);
        }

        return $options;
    }
}
