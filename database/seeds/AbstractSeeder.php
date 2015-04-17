<?php

use Illuminate\Database\Seeder;
use League\Csv\Reader;

abstract class AbstractSeeder extends Seeder
{
    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @param string $fixture
     *
     * @return array|Collection|static
     */
    protected function getFixture($fixture)
    {
        $reader = $this->container->get('paths.fixtures').'/'.$fixture.'.csv';
        $reader = Reader::createFromPath($reader);

        return $reader->fetchAssoc(0);
    }
}
