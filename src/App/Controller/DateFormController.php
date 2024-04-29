<?php

namespace App\Controller;

use App\Dto\DateTimezoneFormDto;
use App\Form\DateTimezoneType;
use Infrastructure\Service\DateTimezone\DateTimezoneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DateFormController extends AbstractController
{
    private DateTimezoneService $dateTimezoneService;

    public function __construct(
        DateTimezoneService $dateTimezoneService
    )
    {
        $this->dateTimezoneService = $dateTimezoneService;
    }

    /**
     * @Route("/datetime_form", name="app_datetime_form")
     */
    public function index(Request $request): Response
    {
        $form = $this->createForm(
            DateTimezoneType::class,
            new DateTimezoneFormDto(),
            ['action' => $this->generateUrl('app_datetime_form')]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $result = $this->dateTimezoneService->getDatetimeZoneObject($form->getData(), 2);

            return $this->render('date_form/result.html.twig', [
                'result' => $result
            ]);
        } else {
            return $this->render('date_form/index.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }
}
