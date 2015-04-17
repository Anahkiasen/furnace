<?php

use Furnace\Entities\Models\Rating;
use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\User;

class RatingsTableMigrator extends AbstractSeeder
{
    public function run()
    {
        $tracks = Track::all();
        $user   = User::whereName('Anahkiasen')->first();

        foreach ($tracks as $track) {
            Rating::create([
                'presilence'        => $track->presilence,
                'normalized_volume' => $track->normalized_volume,
                'playable'          => $track->playable,
                'tone'              => $track->tone,
                'track'             => $track->track,
                'tab'               => $track->tab,
                'user_id'           => $user->id,
                'track_id'          => $track->id,
            ]);
        }
    }
}
