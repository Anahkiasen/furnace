<?php namespace Furnace\Handlers\Commands;

use Furnace\Commands\UpsertTrackCommand;
use Furnace\Entities\Models\Track;
use Furnace\Services\Ignition;

class UpsertTrackCommandHandler
{
    /**
     * @type Ignition
     */
    private $ignition;

    /**
     * @type Track
     */
    private $repository;

    /**
     * @param Ignition $ignition
     * @param Track    $repository
     */
    public function __construct(Ignition $ignition, Track $repository)
    {
        $this->ignition   = $ignition;
        $this->repository = $repository;
    }

    /**
     * Handle the command.
     *
     * @param UpsertTrackCommand $command
     *
     * @return Track
     */
    public function handle(UpsertTrackCommand $command)
    {
        if ($command->track) {
            return $this->repository->findOrFail($command->track);
        }

        // Try to find an existing track with that ignition ID
        $track = $this->repository->where('ignition_id', $command->ignition)->first();
        if ($track) {
            return $track;
        }

        // If we passed an ignition ID, complete it
        // with the actual informations
        $attributes = $this->ignition->complete([
            'ignition_id' => $command->ignition,
        ]);

        return $this->repository->create($attributes);
    }
}
