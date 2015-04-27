<?php
namespace Furnace\Handlers\Commands\Ratings;

use Furnace\Commands\Ratings\ExportRatingsCommand;
use Furnace\Entities\Transformers\RatingExportTransformer;
use League\Csv\Writer;
use SplTempFileObject;

class ExportRatingsCommandHandler
{
    /**
     * @type RatingExportTransformer
     */
    protected $transformer;

    /**
     * ExportRatingsCommandHandler constructor.
     *
     * @param RatingExportTransformer $transformer
     */
    public function __construct(RatingExportTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Handle the command.
     *
     * @param ExportRatingsCommand $command
     *
     * @return Writer
     */
    public function handle(ExportRatingsCommand $command)
    {
        // Get and transform ratings
        $ratings = $command->ratings->map([$this->transformer, 'transform']);

        // Get columns
        $columns = array_keys($ratings->first());

        // Create CSV file
        $file = Writer::createFromFileObject(new SplTempFileObject());
        $file->insertOne($columns);
        $file->insertAll($ratings->toArray());

        return $file;
    }
}
