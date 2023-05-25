<?php

namespace App\DataFixtures;

use App\Entity\Episode;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;


class EpisodeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $seasonReference = $this->getReference('program_1_season_1');

        $episode = new Episode();
        $episode->setSeason($seasonReference);
        $episode->setTitle('Episode 1 : Passé décomposé');
        $episode->setSynopsis('Passé décomposé');
        $episode->setNumber(1);
        $manager->persist($episode);
        $manager->flush();

        $episode = new Episode();
        $episode->setSeason($seasonReference);
        $episode->setTitle('Episode 2 : Tripes');
        $episode->setSynopsis('Tripes');
        $episode->setNumber(2);
        $manager->persist($episode);
        $manager->flush();

        $episode = new Episode();
        $episode->setSeason($seasonReference);
        $episode->setTitle('Episode 3 : T\'as qu\'à discuter avec les grenouilles');
        $episode->setSynopsis('T\'as qu\'à discuter avec les grenouilles');
        $episode->setNumber(3);
        $manager->persist($episode);
        $manager->flush();

        $seasonReference = $this->getReference('program_1_season_2');

        $episode = new Episode();
        $episode->setSeason($seasonReference);
        $episode->setTitle('Episode 1 : Ce qui nous attend');
        $episode->setSynopsis('Ce qui nous attend');
        $episode->setNumber(1);
        $manager->persist($episode);
        $manager->flush();

        $episode = new Episode();
        $episode->setSeason($seasonReference);
        $episode->setTitle('Episode 2 : Saignée');
        $episode->setSynopsis('Saignée');
        $episode->setNumber(2);
        $manager->persist($episode);
        $manager->flush();

        $episode = new Episode();
        $episode->setSeason($seasonReference);
        $episode->setTitle('Episode 3 : Le tout pour tout');
        $episode->setSynopsis('Le tout pour tout');
        $episode->setNumber(3);
        $manager->persist($episode);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            SeasonFixtures::class
        ];
    }
}
