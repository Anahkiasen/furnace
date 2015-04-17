<?php
namespace Furnace\Http\Controllers;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use View;

class HelpController extends AbstractController
{
    /**
     * @Get("help/track-identifier", as="help.identifier")
     */
    public function identifier()
    {
        return View::make('help/identifier');
    }

    /**
     * @Get("help/about", as="help.about")
     *
     * @return \Illuminate\View\View
     */
    public function about()
    {
        return View::make('help/about');
    }
}
