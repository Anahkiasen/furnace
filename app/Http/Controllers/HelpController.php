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
}
