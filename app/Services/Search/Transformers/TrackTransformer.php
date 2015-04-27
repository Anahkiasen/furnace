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
        $transformed = [
            'id'                => $track->id,
            'album'             => $track->album,
            'name'              => $track->name,
            'slug'              => $track->slug,
            'parts'             => $track->parts,
            'tuning'            => $track->tuning,
            'version'           => $track->version ? $track->version->name : null,
            'dd'                => (bool) $track->dd,
            'riff_repeater'     => (bool) $track->riff_repeater,
            'difficulty_levels' => (int) $track->difficulty_levels,
            'platforms'         => $track->platforms,
            'score'             => (float) $track->score,
            'tracker'           => $track->tracker ? $track->tracker->name : null,
        ];

        if ($track->artist) {
            $transformed = array_merge($transformed, [
                'artist' => $track->artist->name,
                'tags'   => $track->artist->tags,
            ]);
        }

        return $transformed;
    }
}
