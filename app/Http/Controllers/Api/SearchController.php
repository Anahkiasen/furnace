<?php
namespace Furnace\Http\Controllers\Api;

use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Furnace\Http\Controllers\AbstractController;
use Furnace\Services\Ignition;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class SearchController extends AbstractController
{
    /**
     * @type Ignition
     */
    private $ignition;

    /**
     * @param Ignition $ignition
     */
    public function __construct(Ignition $ignition)
    {
        $this->ignition = $ignition;
    }

    /**
     * @Get("api/search")
     *
     * @param Request $request
     *
     * @return array
     */
    public function search(Request $request)
    {
        $tracks  = [];
        try {
            $results = $this->ignition->search($request->get('q'));
            foreach ($results as $result) {
                $tracks[] = [
                    'id'     => $result[0],
                    'artist' => $result[1],
                    'title'  => $result[2],
                    'user'   => $result[6],
                    'label'  => sprintf('%s - %s by %s', $result[1], $result[2], $result[6]),
                ];
            }
        } catch (RequestException $exception) {
            return [];
        }

        return $tracks;
    }
}
