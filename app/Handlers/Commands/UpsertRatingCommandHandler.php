<?php
namespace Furnace\Handlers\Commands;

use Furnace\Commands\UpsertRatingCommand;
use Furnace\Commands\UpsertTrackCommand;
use Furnace\Entities\Models\Rating;
use Illuminate\Foundation\Bus\DispatchesCommands;

class UpsertRatingCommandHandler
{
    use DispatchesCommands;

    /**
     * @type Rating
     */
    private $repository;

    /**
     * @param Rating $repository
     */
    public function __construct(Rating $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle the command.
     *
     * @param UpsertRatingCommand $command
     *
     * @return Rating
     */
    public function handle(UpsertRatingCommand $command)
    {
        $track = $this->dispatchFromArray(UpsertTrackCommand::class, [
            'ignition' => $command->attributes->get('ignition_id'),
        ]);

        // Create rating instance
        $rating = $command->rating ?: new Rating();

        // Update rating
        $rating->fill($command->attributes->all());
        $rating->track_id = $track->id;
        $rating->user_id  = $command->user->id;
        $rating->save();

        return $rating;
    }
}
