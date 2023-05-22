<?php

namespace App\DataFixtures;

use App\Entity\Program;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $categories = [
            $this->getReference('category_Action'),
            $this->getReference('category_Aventure'),
            $this->getReference('category_Animation'),
            $this->getReference('category_Fantastique'),
            $this->getReference('category_Horreur'),
        ];

        for ($i = 1; $i <= 5; $i++) {
            $program = new Program();
            $program->setTitle('Program ' . $i);
            $program->setSynopsis('Synopsis for Program ' . $i);
            $program->setCategory($categories[array_rand($categories)]);
            $program->setPoster('default_poster.jpg');

            $manager->persist($program);
        }

        $manager->flush();
    }


    public function getDependencies(): array
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
            CategoryFixtures::class,
        ];
    }
}
