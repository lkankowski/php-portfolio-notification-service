<?php

namespace App\Entity;

use App\Repository\UserChannelsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserChannelsRepository::class)]
class UserChannels
{
    #[ORM\Id]
    #[ORM\OneToOne(inversedBy: 'userChannels', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private ?User $user = null;

    #[ORM\Column(type: Types::JSON)]
    private ?string $config = null;

    public function __construct(
        $user,
    ) {
        $this->user = $user;
    }

    /** @return array<string, string> */
    public function getConfigJson(): array
    {
        try {
            $config = \json_decode($this->config, true, flags: \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            $config = [];
        }
        return $config;
    }

    public function setConfig(string $config): self
    {
        $this->config = $config;

        return $this;
    }
}
