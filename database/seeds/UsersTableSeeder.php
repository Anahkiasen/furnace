<?php
use Furnace\Entities\Models\User;

class UsersTableSeeder extends AbstractSeeder
{
    public function run()
    {
        User::create([
            'name'     => 'Anahkiasen',
            'email'    => 'ehtnam6@gmail.com',
            'password' => 'furnace',
        ]);
    }
}
