<?php
namespace Furnace\Services\Search\Transformers;

use Furnace\Entities\Models\Track;
use League\Fractal\TransformerAbstract;

class TrackTransformer extends TransformerAbstract
{
    /**
     * @param Track $track
     *
     * @return array
     */
    public function transform(Track $track)
    {
        return [
            'artist'            => $track->artist,
            'album'             => $track->album,
            'name'              => $track->name,
            'slug'              => $track->slug,
            'parts'             => $track->parts,
            'tuning'            => $track->tuning,
            'version'           => $track->version,
            'dd'                => (bool) $track->dd,
            'riff_repeater'     => (bool) $track->riff_repeater,
            'difficulty_levels' => (int) $track->difficulty_levels,
            'platforms'         => $track->platforms,
            'score'             => (int) $track->score,
        ];
    }
}
