<?php

return [

    // The platforms a CDLC can be used on
    'platforms'    => [
        'xbox360',
        'ps3',
        'pc',
        'mac'
    ],

    // The difficulties a CDLC can be rated as
    'difficulties' => [
        'Easy',
        'Average',
        'Hard',
        'Master',
    ],

    // The weights of the score criterias
    'weights'      => [
        'tone'              => 1,
        'audio'             => 1,
        'sync'              => 1,
        'techniques'        => 1,
        'tab'               => 1,
        'normalized_volume' => 1,
        'presilence'        => 1,
        'playable'          => 1,
        'dd'                => 1,
        'riff_repeater'     => 1,
        'difficulty_levels' => 1,
        'has_pc'            => 1,
        'platforms'         => 1,
    ],

];
