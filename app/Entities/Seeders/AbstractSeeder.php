<?php
namespace Furnace\Entities\Seeders;

use Illuminate\Database\Seeder;
use League\Csv\Reader;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractSeeder extends Seeder
{
    /**
     * @type OutputInterface
     */
    protected $output;

    /**
     * @param OutputInterface $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

    //////////////////////////////////////////////////////////////////////
    ////////////////////////////// HELPERS ///////////////////////////////
    //////////////////////////////////////////////////////////////////////

    /**
     * @return array|Collection|static
     */
    protected function getFixture($fixture)
    {
        $reader = $this->container->get('paths.fixtures').'/'.$fixture.'.csv';
        $reader = Reader::createFromPath($reader);

        return $reader->fetchAssoc(0);
    }
}
