<?php

namespace Epsoftware\PerfilBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Epsoftware\PerfilBundle\Entity\Profissao;
use Symfony\Component\Finder\Finder;

class LoadProfissaoData extends AbstractFixture implements OrderedFixtureInterface 
{
    
    // change these options about the file to read
    private $csvParsingOptions = array(
        'finder_in' => 'src/Epsoftware/PerfilBundle/Resources/files',
        'finder_name' => 'Profissoes.csv',
        'ignoreFirstLine' => false
    );
    
    
    public function load(ObjectManager $manager)
    {
        $profissoes = $this->parseCSV();
        foreach ($profissoes as $profissao):
            $this->createProfissao($manager, $profissao[0]);
        endforeach;
        $manager->flush();
    }
    
    private function createProfissao(ObjectManager $manager, $profissao)
    {
        $profissaoOb = new Profissao();
        $profissaoOb->setProfissao($profissao);
        $manager->persist($profissaoOb);
    }
    
    /**
     * Parse a csv file
     * 
     * @return array
     */
    private function parseCSV()
    {
        $ignoreFirstLine = $this->csvParsingOptions['ignoreFirstLine'];

        $finder = new Finder();
        $finder->files()
            ->in($this->csvParsingOptions['finder_in'])
            ->name($this->csvParsingOptions['finder_name'])
        ;
        foreach ($finder as $file) { $csv = $file; }

        $rows = array();
        if (($handle = fopen($csv->getRealPath(), "r")) !== FALSE) {
            $i = 0;
            while (($data = fgetcsv($handle, null, ";")) !== FALSE) {
                $i++;
                if ($ignoreFirstLine && $i == 1) { continue; }
                $rows[] = $data;
            }
            fclose($handle);
        }
        
        return $rows;
    }
    
    public function getOrder()
    {
        return 50;
    }
}
