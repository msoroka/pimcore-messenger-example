<?php

namespace App\MessageHandler;

use App\Message\CompetitionApplicationMessage;
use Carbon\Carbon;
use Exception;
use Pimcore\Mail;
use Pimcore\Model\DataObject\Service;

class CompetitionApplicationMessageHandler
{
    /**
     * @throws Exception
     */
    public function __invoke(CompetitionApplicationMessage $competitionApplicationMessage): void
    {
        $competitionApplication = $competitionApplicationMessage->getCompetitionApplication();

        $now = Carbon::now();

        $competitionApplication->setDate($now);
        $competitionApplication->setKey($now->timestamp);
        $competitionApplication->setPublished(true);
        $competitionApplication->setParent(Service::createFolderByPath($now->format('/Y/m/d')));
        $competitionApplication->save();

        $mail = new Mail();
        $mail->to('competition@example.com');
        $mail->subject('New competition application');
        $mail->html("<p>Firstname: {{ firstname }}</p><p>Email: {{ email }}</p><p>Message: {{ message }}</p>");
        $mail->setParams([
            'firstname' => $competitionApplication->getFirstname(),
            'email' => $competitionApplication->getEmail(),
            'message' => $competitionApplication->getMessage(),
        ]);

        $mail->send();
    }
}
