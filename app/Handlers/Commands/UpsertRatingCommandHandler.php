<?php
namespace Furnace\Handlers\Commands;

use Furnace\Commands\UpsertRatingCommand;
use Furnace\Entities\Models\Rating;

class UpsertRatingCommandHandler
{
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
        $rating = $command->rating ?: new Rating();

        // Update rating
        $rating->fill($command->attributes);
        $rating->save();

        return $rating;
    }
}
