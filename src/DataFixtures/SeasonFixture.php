<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;

class SeasonFixture extends Fixture implements DependentFixtureInterface
{
    
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<10;$i++){
            $season = new Season();
            $season->setNumber($i);
            $season->setProgram($this->getReference('program_'.random_int(0,4)));
            $season->setYear(strval(random_int(1990,2004)));
            $season->setDescription("This description");
            $manager->persist($season);
            $this->addReference('season_'.$i,$season);
        }            
       
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ProgramFixture::class,
        ];
    }
   
}
