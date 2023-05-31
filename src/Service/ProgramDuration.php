<?php

namespace App\Service;

use App\Entity\Program;

class ProgramDuration
{
    public function calculate(Program $program): string
    {
        $totalMinutes = 0;

        foreach ($program->getSeasons() as $season) {
            foreach ($season->getEpisodes() as $episode) {
                $totalMinutes += $episode->getDuration();
            }
        }

        $days = floor($totalMinutes / 1440); // 1440 minutes = 1 jour
        $hours = floor(($totalMinutes % 1440) / 60);
        $minutes = $totalMinutes % 60;

        $duration = '';

        if ($days > 0) {
            $duration .= $days . ' jour' . ($days > 1 ? 's' : '') . ' ';
        }

        if ($hours > 0) {
            $duration .= $hours . ' heure' . ($hours > 1 ? 's' : '') . ' ';
        }

        if ($minutes > 0) {
            $duration .= $minutes . ' minute' . ($minutes > 1 ? 's' : '');
        }

        return $duration;
    }
}