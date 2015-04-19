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
            'techniques'        => ['Techniques', '1 or 0'],
            'tab'               => ['Tab quality'],
            'normalized_volume' => ['Normalized volume', '1 or 0'],
            'presilence'        => ['Pre-silence', '1 or 0'],
            'playlable'         => ['Playable', '1 or 0'],
            'dd'                => ['Dynamic difficulty', '1 or 0'],
            'rr'                => ['Riff Repeater', '1 or 0'],
            'has_pc'            => ['PC version available', '1 or 0'],
            'difficulty_levels' => ['Difficulty levels', 'Ratio to 5'],
            'platforms'         => ['Platforms', 'Ratio to 4, grants extra points'],
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
