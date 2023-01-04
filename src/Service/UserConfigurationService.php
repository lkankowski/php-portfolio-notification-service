<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\UserChannelsData;
use App\Entity\User;
use App\Entity\UserChannels;
use App\Repository\UserChannelsRepository;
use App\Repository\UserRepository;

final class UserConfigurationService
{
    public function __construct(
        private readonly UserChannelsRepository $channelsRepository,
        private readonly UserRepository $userRepository,
    )
    {}

    public function getChannelsConfiguration(User $user): array
    {
        return $user->getUserChannels()?->getConfigJson() ?? [];
    }

    public function saveUserChannels(UserChannelsData $userChannelsData): void
    {
        $userChannels = $this->channelsRepository->find($userChannelsData->userId);
        if (!$userChannels) {
            $user = $this->userRepository->find($userChannelsData->userId);
            $userChannels = new UserChannels($user);
        }

        $userChannels->setConfig($userChannelsData->configJson);
        $this->channelsRepository->save($userChannels, true);
    }
}
