<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EpisodeFixture extends Fixture implements DependentFixtureInterface
{
    const EPISODE =[
        "Configuration matrimoniale",
        "Un mysterieux cadeau de mariage",
        "Une procreation calculee",
        "La Trahison de Tam",
        "Crise au planetarium",
        "Un Halloween sous tension",
        "La Derivation des subventions",
        "Le Test de compatibilite",
        "La Theorie dejouee"
    ];

    public Slugify $slugify;

    public function __construct(Slugify $slugify)
    {
        $this->slugify=$slugify;
    }

    public function load(ObjectManager $manager) 
    {
        foreach(self::EPISODE as $key => $episodeName)
        {
            $episode = new Episode();    
            $episode->setTitle($episodeName);
            $episode->setNumber($key); 
            $episode->setSynopsis("This is the synopsis");
            $episode->setSeason($this->getReference('season_'.random_int(0,4))); 
            $episode->setSlug($this->slugify->generate($episodeName));     
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
