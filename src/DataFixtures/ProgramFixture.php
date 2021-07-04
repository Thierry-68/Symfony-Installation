<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Program;

class ProgramFixture extends Fixture implements DependentFixtureInterface
{
    const PROGRAMS=[
        "The Walking Dead",
        "Deadpool",
        "Fear the Walking Dead",
        "COMOS 1999",
        "Avengers: Endgame"
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::PROGRAMS as $key =>$programName)
        {
            $program = new Program();       
            $program->setTitle($programName);
            $program->setSummary('Des zombies envahissent la terre');     
            $program->setSlug("");       
            for($i=0;$i<count(ActorFixtures::ACTORS); $i++){
                $program->addActor($this->getReference('actor_'.$i));                    
            }    
            $program->setCategory($this->getReference('category_'.strval(random_int(0,4))));                  
            $manager->persist($program);
            $this->addReference('program_'.$key,$program);  
        }
        
        $manager->flush();
    }

    public function getDependencies()
    {
        return[
            CategoryFixtures::class,
            ActorFixtures::class,
        ];
    }
}
