<?php

namespace App\Service;

class DeclarationService
{
    public function createYearsArray(): array
    {
        $dateArray = [];
        for ($i=0; $i <= 3; $i++) {
            $dateArray[] = date('Y', strtotime('-'.$i.' years'));
        }
        sort($dateArray);

        return $dateArray;
    }
}