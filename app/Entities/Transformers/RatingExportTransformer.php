<?php
namespace Furnace\Entities\Transformers;

use Furnace\Entities\Models\Rating;
use League\Fractal\TransformerAbstract;

class RatingExportTransformer extends TransformerAbstract
{
    /**
     * @param Rating $rating
     *
     * @return array
     */
    public function transform(Rating $rating)
    {
        return [
            'ignition_id'       => $rating->track->ignition_id,
            'version_id'        => $rating->version_id,
            'presilence'        => $rating->presilence,
            'normalized_volume' => $rating->normalized_volume,
            'playable'          => $rating->playable,
            'tone'              => $rating->tone,
            'audio'             => $rating->audio,
            'sync'              => $rating->sync,
            'techniques'        => $rating->techniques,
            'tab'               => $rating->tab,
            'difficulty'        => $rating->difficulty,
            'comments'          => $rating->comments,
        ];
    }
}
