<?php

namespace App\Controller;

use App\DTO\NotificationFormData;
use App\Entity\User;
use App\Form\NotificationFormType;
use App\MessagingProvider\NotificationServiceResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class NotificationController extends AbstractController
{
    public function __construct(
        private readonly NotificationServiceResolver $serviceLocator,
    )
    {}

    #[Route('/send/notification', name: 'app_send_notification')]
    #[IsGranted('ROLE_USER')]
    public function send(
        Request $request,
        #[CurrentUser] User $user,
    ): Response
    {
        $form = $this->createForm(NotificationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $config = $user->getUserChannels()?->getConfigJson();
            if ($config) {

                /** @var NotificationFormData $notificationData */
                $notificationData = $form->getData();
                if ($this->serviceLocator->sendWithFallback($notificationData, $config)) {
                    $this->addFlash('success', 'Notification sent');
                } else {
                    $this->addFlash('danger', 'Unable to send notification - try again or contact with support');
                }
            } else {
                $this->addFlash('warning', 'Missing channels configuration');
                return $this->redirectToRoute('app_channels');
            }
            return $this->redirect($request->getUri());
        }

        return $this->render('notification/send.html.twig', [
            'notificationForm' => $form->createView(),
        ]);
    }
}
