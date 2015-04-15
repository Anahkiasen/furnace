<?php
namespace Notetracker\Seeders;

use League\Container\ContainerAwareTrait;
use League\Csv\Reader;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractSeeder
{
    use ContainerAwareTrait;

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
        $reader = $this->container->get('paths.fixtures').'/' .$fixture. '.csv';
        $reader = Reader::createFromPath($reader);

        return $reader->fetchAssoc(0);
    }
}
