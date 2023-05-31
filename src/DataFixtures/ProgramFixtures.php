<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }


    public function load(ObjectManager $manager): void
    {
        $program = new Program();
        $program->setTitle('Walking Dead');
        $program->setSynopsis('une épidémie post-apocalyptique a transformé la quasi-totalité de la population américaine et mondiale en mort-vivants ou « rôdeurs »');
        $program->setCategory($this->getReference('category_Action'));
        $program->setYear(2023);
        $program->setPoster('walking_dead.jpeg');
        $program->setSlug($this->slugger->slug($program->getTitle()));
        $manager->persist($program);
        $this->addReference('program_1', $program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('Arcane');
        $program->setSynopsis('Série animée qui se déroule dans l\'univers de la franchise de jeu vidéo "League of Legends".');
        $program->setCategory($this->getReference('category_Aventure'));
        $program->setYear(2023);
        $program->setPoster('arcane.jpg');
        $program->setSlug($this->slugger->slug($program->getTitle()));
        $manager->persist($program);
        $this->addReference('program_2', $program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('Les Simpsons');
        $program->setSynopsis('Meilleur dessin animés des années 1980');
        $program->setCategory($this->getReference('category_Animation'));
        $program->setYear(2023);
        $program->setPoster('les_simpsons.jpeg');
        $program->setSlug($this->slugger->slug($program->getTitle()));
        $manager->persist($program);
        $this->addReference('program_3', $program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('Game of throne');
        $program->setSynopsis('Dans un pays où l\'été peut durer plusieurs années et l\'hiver toute une vie, des forces sinistres et surnaturelles se pressent aux portes du Royaume des Sept Couronnes');
        $program->setCategory($this->getReference('category_Fantastique'));
        $program->setYear(2023);
        $program->setPoster('game_of_throne.webp');
        $program->setSlug($this->slugger->slug($program->getTitle()));
        $manager->persist($program);
        $this->addReference('program_4', $program);
        $manager->flush();

        $program = new Program();
        $program->setTitle('Penny dreadful');
        $program->setSynopsis('Un thriller "psychosexuel" réunissant Dracula, Van Helsing, Dorian Gray ou encore Frankenstein dans le Londres de l\'époque Victorienne.');
        $program->setCategory($this->getReference('category_Horreur'));
        $program->setYear(2023);
        $program->setPoster('penny_dreadful.jpeg');
        $program->setSlug($this->slugger->slug($program->getTitle()));
        $manager->persist($program);
        $this->addReference('program_5', $program);
        $manager->flush();
    }
    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class
        ];
    }

}
