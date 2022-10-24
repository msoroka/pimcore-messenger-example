<?php

namespace App\Message;

use Pimcore\Model\DataObject\CompetitionApplication;

class CompetitionApplicationMessage
{
    public function __construct(
        private readonly CompetitionApplication $competitionApplication
    ) {
    }

    public function getCompetitionApplication(): CompetitionApplication
    {
        return $this->competitionApplication;
    }
}
