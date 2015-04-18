<?php

use Furnace\Entities\Models\User;
use League\FactoryMuffin\Facade;

Facade::define(User::class, [
    'name'     => 'word',
    'email'    => 'email',
    'password' => 'word',
]);
