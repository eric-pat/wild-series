<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Season;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $program = $this->getReference('program_1');

        $season = new Season();
        $season->setProgram($program);
        $season->setNumber(1);
        $season->setYear(2021);
        $season->setDescription('default description saison 1');

        $manager->persist($season);

        $this->addReference('program_1_season_1',  $season);

        $program = $this->getReference('program_1');

        $season = new Season();
        $season->setProgram($program);
        $season->setNumber(2);
        $season->setYear(2023);
        $season->setDescription('default description saison 2');

        $manager->persist($season);

        $this->addReference('program_1_season_2',  $season);

        $manager->flush();


    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class
        ];
    }
}
