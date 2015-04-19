<?php
namespace Furnace\Console\Commands;

use Furnace\Entities\Models\Track;
use Furnace\Entities\Models\User;

class UpdateSlugs extends AbstractCommand
{
    /**
     * @type string
     */
    protected $name = 'furnace:slugs';

    /**
     * @type string
     */
    protected $description = 'Updates all the slugs at once';

    /**
     * Run the command.
     */
    public function handle()
    {
        $this->onTracks(function (Track $track) {
            $track->save();
        });

        $this->onModel(User::class, function (User $user) {
            $user->save();
        });
    }

}
