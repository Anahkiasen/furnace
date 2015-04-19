<?php
namespace Furnace\Http\Composers;

use Config;
use Illuminate\View\View;

class HelpComposer
{
    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $weights   = Config::get('furnace.weights');
        $criterias = [
            'tone'              => ['Tones quality'],
            'audio'             => ['Audio quality'],
            'sync'              => ['In sync'],
            'techniques'        => ['Techniques'],
            'tab'               => ['Tab quality'],
            'normalized_volume' => ['Normalized volume'],
            'presilence'        => ['Pre-silence'],
            'playlable'         => ['Playable'],
            'dd'                => ['Dynamic difficulty'],
            'rr'                => ['Riff Repeater'],
            'difficulty_levels' => ['Difficulty levels', 'Ratio to 5'],
            'platforms'         => ['Platforms', 'Grants extra points'],
        ];

        foreach ($criterias as $key => &$criteria) {
            $criteria = [
                'label'  => $criteria[0],
                'notes'  => array_get($criteria, 1),
                'weight' => $weights[$key],
            ];
        }

        $view->criterias = $criterias;
    }
}
