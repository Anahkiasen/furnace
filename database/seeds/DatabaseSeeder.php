<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        $this->call('UsersTableSeeder');

        if (!$this->container->environment('testing')) {
            $this->call('TracksTableSeeder');
        }
    }
}
