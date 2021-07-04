<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ActorFixtures extends Fixture
{
    const ACTORS = [
        'Ryan Reynolds',
        'Morena Baccarin',
        'Ed Skrein',
        'Kim Dickens',
        'Frank Dillane',
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::ACTORS as $key => $actorName){
            $actor=new Actor();
            $actor->setName($actorName);
            $this->addReference("actor_".$key,$actor);
            $manager->persist($actor);
        }

        $manager->flush();
    }

    
}
