<?php

namespace App\Twig\Components;

use App\Repository\EpisodeRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('last_episode')]
final class LastEpisodeComponent
{
    public function __construct(
        private readonly EpisodeRepository $episodeRepository
    ) {
    }

    public function getEpisodes(): array
    {
        return $this->episodeRepository->findBy([], ['title' => 'ASC']);
    }
}


