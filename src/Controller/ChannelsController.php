<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserChannels;
use App\Form\ChannelsFormType;
use Doctrine\ORM\EntityManagerInterface;
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
        EntityManagerInterface $entityManager
    ): Response
    {
        $userChannels = $user->getUserChannels() ?? new UserChannels();
        $form = $this->createForm(ChannelsFormType::class, $userChannels->getConfigJson());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $userChannels->setConfig(\json_encode($form->getData(),  \JSON_THROW_ON_ERROR));
            $entityManager->persist($userChannels);
            $entityManager->flush();

            return $this->redirectToRoute('main');
        }

        return $this->render('user/channels.html.twig', [
            'channelsForm' => $form->createView(),
        ]);
    }
}
