<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager): void
    {
//        $program = $this->getReference('program_1');
//
//        $season = new Season();
//        $season->setProgram($program);
//        $season->setNumber(1);
//        $season->setYear(2021);
//        $season->setDescription('default description saison 1');
//
//        $manager->persist($season);
//
//        $this->addReference('program_1_season_1',  $season);
//
//        $program = $this->getReference('program_1');
//
//        $season = new Season();
//        $season->setProgram($program);
//        $season->setNumber(2);
//        $season->setYear(2023);
//        $season->setDescription('default description saison 2');
//
//        $manager->persist($season);
//
//        $this->addReference('program_1_season_2',  $season);
//
//        $manager->flush();

        $faker = Factory::create();

        for ($program = 1; $program <= 5; $program++) {
            for ($saison = 1; $saison <=5; $saison++) {

                $season = new Season();
                $season->setNumber($saison);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(1, true));
                $season->setProgram($this->getReference('program_' . $program));

                $title = 'Season ' . $saison;
                $slug = $this->slugger->slug($title);
                $season->setSlug($slug);

                $manager->persist($season);
                $this->addReference('program_' . $program . '_season_' . $saison, $season);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            ProgramFixtures::class
        ];
    }
}
