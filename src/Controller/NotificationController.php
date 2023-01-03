<?php

namespace App\Controller;

use App\DTO\NotificationFormData;
use App\Form\NotificationFormType;
use App\MessagingProvider\NotificationServiceLocator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NotificationController extends AbstractController
{
    public function __construct(
        private readonly NotificationServiceLocator $serviceLocator,
    )
    {}

    #[Route('/notification', name: 'notification')]
    public function register(Request $request): Response
    {
        $form = $this->createForm(NotificationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var NotificationFormData $notificationData */
            $notificationData = $form->getData();
            $this->serviceLocator->sendWithFallback($notificationData);
        }

        return $this->render('main/index.html.twig', [
            'notificationForm' => $form->createView(),
        ]);
    }
}
