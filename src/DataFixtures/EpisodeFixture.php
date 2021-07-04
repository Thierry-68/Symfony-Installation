<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixture extends Fixture implements DependentFixtureInterface
{
    const EPISODE =[
        "Configuration matrimoniale",
        "Un mystérieux cadeau de mariage",
        "Une procréation calculée",
        "La Trahison de Tam",
        "Crise au planétarium",
        "Un Halloween sous tension",
        "La Dérivation des subventions",
        "Le Test de compatibilité",
        "La Théorie déjouée"
    ];

    public function load(ObjectManager $manager) 
    {
        foreach(self::EPISODE as $key => $episodeName)
        {
            $episode = new Episode();    
            $episode->setTitle($episodeName);
            $episode->setNumber($key); 
            $episode->setSynopsis("This is the synopsis");
            $episode->setSeason($this->getReference('season_'.random_int(0,4)));      
            $manager->persist($episode);
        }
              
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            SeasonFixture::class,
        ];
    }
}
