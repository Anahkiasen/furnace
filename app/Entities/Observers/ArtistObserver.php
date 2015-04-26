<?php
namespace Furnace\Entities\Observers;

use Furnace\Entities\Models\Artist;
use Furnace\Services\Lastfm;

class ArtistObserver
{
    /**
     * @type Lastfm
     */
    protected $lastfm;

    /**
     * ArtistObserver constructor.
     *
     * @param Lastfm $lastfm
     */
    public function __construct(Lastfm $lastfm)
    {
        $this->lastfm = $lastfm;
    }

    /**
     * @param Artist $artist
     */
    public function saving(Artist $artist)
    {
        $artist->tags = $this->lastfm->getArtistTags($artist->name);
    }
}
