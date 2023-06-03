<?php

namespace App\DataFixtures;

use App\DataFixtures\UserFixtures;
use App\Entity\Program;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\String\Slugger\SluggerInterface;
use Doctrine\Common\Collections\ArrayCollection;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    private SluggerInterface $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function load(ObjectManager $manager)
    {
        $programsData = [
            [
                'title' => 'Walking Dead',
                'synopsis' => 'Une épidémie post-apocalyptique a transformé la quasi-totalité de la population américaine et mondiale en mort-vivants ou « rôdeurs »',
                'category' => 'category_Action',
                'year' => 2010,
                'poster' => 'walking_dead.jpeg',
            ],
            [
                'title' => 'Arcane',
                'synopsis' => 'Série animée qui se déroule dans l\'univers de la franchise de jeu vidéo "League of Legends".',
                'category' => 'category_Aventure',
                'year' => 2021,
                'poster' => 'arcane.jpg',
            ],
            [
                'title' => 'Les Simpsons',
                'synopsis' => 'Meilleur dessin animé des années 1980',
                'category' => 'category_Animation',
                'year' => 1989,
                'poster' => 'les_simpsons.jpeg',
            ],
            [
                'title' => 'Game of Thrones',
                'synopsis' => 'Dans un pays où l\'été peut durer plusieurs années et l\'hiver toute une vie, des forces sinistres et surnaturelles se pressent aux portes du Royaume des Sept Couronnes',
                'category' => 'category_Fantastique',
                'year' => 2011,
                'poster' => 'game_of_thrones.webp',
            ],
            [
                'title' => 'Penny Dreadful',
                'synopsis' => 'Un thriller "psychosexuel" réunissant Dracula, Van Helsing, Dorian Gray ou encore Frankenstein dans le Londres de l\'époque Victorienne.',
                'category' => 'category_Horreur',
                'year' => 2014,
                'poster' => 'penny_dreadful.jpeg',
            ],
        ];

        foreach ($programsData as $key => $programData) {
            $program = new Program();
            $program->setTitle($programData['title']);
            $program->setSynopsis($programData['synopsis']);
            $program->setCategory($this->getReference($programData['category']));
            $program->setYear($programData['year']);
            $program->setPoster($programData['poster']);
            $program->setSlug($this->slugger->slug($program->getTitle()));

            if (isset($programData['owner'])) {
                $program->setOwner($this->getReference(UserFixtures::CONTRIBUTOR_REFERENCE));
            }

            $manager->persist($program);
            $this->addReference('program_' . ($key + 1), $program);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::class,
        ];
    }

//    public function load(ObjectManager $manager): void
//    {
//        $program = new Program();
//        $program->setTitle('Walking Dead');
//        $program->setSynopsis('une épidémie post-apocalyptique a transformé la quasi-totalité de la population américaine et mondiale en mort-vivants ou « rôdeurs »');
//        $program->setCategory($this->getReference('category_Action'));
//        $program->setYear(2023);
//        $program->setPoster('walking_dead.jpeg');
//        $program->setSlug($this->slugger->slug($program->getTitle()));
//        $manager->persist($program);
//        $this->addReference('program_1', $program);
//        $manager->flush();
//
//        $user = $this->getReference(UserFixtures::CONTRIBUTOR_REFERENCE);
//
//        $program = new Program();
//        $program->setOwner($user);
//        $program->setTitle('Arcane');
//        $program->setSynopsis('Série animée qui se déroule dans l\'univers de la franchise de jeu vidéo "League of Legends".');
//        $program->setCategory($this->getReference('category_Aventure'));
//        $program->setYear(2023);
//        $program->setPoster('arcane.jpg');
//        $program->setSlug($this->slugger->slug($program->getTitle()));
//        $manager->persist($program);
//        $this->addReference('program_2', $program);
//        $manager->flush();
//
//        $program = new Program();
//        $program->setTitle('Les Simpsons');
//        $program->setSynopsis('Meilleur dessin animés des années 1980');
//        $program->setCategory($this->getReference('category_Animation'));
//        $program->setYear(2023);
//        $program->setPoster('les_simpsons.jpeg');
//        $program->setSlug($this->slugger->slug($program->getTitle()));
//        $manager->persist($program);
//        $this->addReference('program_3', $program);
//        $manager->flush();
//
//        $program = new Program();
//        $program->setTitle('Game of throne');
//        $program->setSynopsis('Dans un pays où l\'été peut durer plusieurs années et l\'hiver toute une vie, des forces sinistres et surnaturelles se pressent aux portes du Royaume des Sept Couronnes');
//        $program->setCategory($this->getReference('category_Fantastique'));
//        $program->setYear(2023);
//        $program->setPoster('game_of_thrones.webp');
//        $program->setSlug($this->slugger->slug($program->getTitle()));
//        $manager->persist($program);
//        $this->addReference('program_4', $program);
//        $manager->flush();
//
//        $program = new Program();
//        $program->setTitle('Penny dreadful');
//        $program->setSynopsis('Un thriller "psychosexuel" réunissant Dracula, Van Helsing, Dorian Gray ou encore Frankenstein dans le Londres de l\'époque Victorienne.');
//        $program->setCategory($this->getReference('category_Horreur'));
//        $program->setYear(2023);
//        $program->setPoster('penny_dreadful.jpeg');
//        $program->setSlug($this->slugger->slug($program->getTitle()));
//        $manager->persist($program);
//        $this->addReference('program_5', $program);
//        $manager->flush();
//    }


}
