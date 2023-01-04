<?php

namespace App\Controller;

use App\DTO\UserChannelsData;
use App\Entity\User;
use App\Form\ChannelsFormType;
use App\Service\UserConfigurationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ChannelsController extends AbstractController
{
    #[Route('/channels', name: 'app_channels')]
    #[IsGranted('ROLE_USER')]
    public function index(
        Request $request,
        #[CurrentUser] User $user,
        UserConfigurationService $userConfigurationService,
    ): Response
    {
        $userChannelsConfigJson = $userConfigurationService->getChannelsConfiguration($user);

        $form = $this->createForm(ChannelsFormType::class, $userChannelsConfigJson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $userChannelsData = new UserChannelsData($user->getId(), \json_encode($form->getData(),  \JSON_THROW_ON_ERROR));
            $userConfigurationService->saveUserChannels($userChannelsData);

            return $this->redirectToRoute('main');
        }

        return $this->render('user/channels.html.twig', [
            'channelsForm' => $form->createView(),
        ]);
    }
}
