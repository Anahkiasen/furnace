<?php namespace Furnace\Handlers\Commands\Ratings;

use Furnace\Commands\Ratings\ImportRatingsCommand;
use Furnace\Commands\UpsertTrackCommand;
use Furnace\Entities\Models\Rating;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Support\Arr;

class ImportRatingsCommandHandler
{
    use DispatchesCommands;

    /**
     * @type Rating[]
     */
    protected $ratings = [];

    /**
     * Handle the command.
     *
     * @param ImportRatingsCommand $command
     *
     * @return Rating[]
     */
    public function handle(ImportRatingsCommand $command)
    {
        foreach ($command->ratings as $rating) {
            if (!$rating['ignition_id']) {
                continue;
            }

            // Create underlying track, version and artist if necessary
            $track = $this->dispatchFromArray(UpsertTrackCommand::class, [
                'ignition' => $rating['ignition_id'],
            ]);

            // Create rating
            unset($track->versions);
            $this->ratings[] = Rating::create([
                'presilence'        => Arr::get($rating, 'presilence'),
                'normalized_volume' => Arr::get($rating, 'normalized_volume'),
                'playable'          => Arr::get($rating, 'playable'),
                'tone'              => Arr::get($rating, 'tone'),
                'audio'             => Arr::get($rating, 'track'),
                'sync'              => Arr::get($rating, 'sync', true),
                'techniques'        => Arr::get($rating, 'techniques', true),
                'tab'               => Arr::get($rating, 'tab'),
                'difficulty'        => Arr::get($rating, 'difficulty', 1),
                'version_id'        => Arr::get($rating, 'version_id') ?: $track->version->id,
                'track_id'          => $track->id,
                'user_id'           => $command->user->id,
            ]);
        }

        return $this->ratings;
    }
}
