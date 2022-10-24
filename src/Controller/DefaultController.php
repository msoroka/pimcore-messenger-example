<?php

namespace App\Controller;

use App\Form\Type\CompetitionApplicationType;
use App\Message\CompetitionApplicationMessage;
use Exception;
use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\CompetitionApplication;
use Pimcore\Translation\Translator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class DefaultController extends FrontendController
{
    public function defaultAction(Request $request, Translator $translator, MessageBusInterface $bus): Response
    {
        $competitionApplication = new CompetitionApplication();

        $form = $this->createForm(CompetitionApplicationType::class, $competitionApplication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $competitionApplication = $form->getData();

            try {
                $bus->dispatch(new CompetitionApplicationMessage($competitionApplication));
                $this->addFlash('success', $translator->trans('form.competition-application.success'));
            } catch (Exception $e) {
                $this->addFlash('error', $translator->trans('form.competition-application.error'));
            }
        }

        return $this->render('default/default.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
