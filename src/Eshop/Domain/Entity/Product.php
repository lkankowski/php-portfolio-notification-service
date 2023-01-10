<?php

namespace App\Eshop\Domain\Entity;

use App\Eshop\Infrastructure\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[UniqueEntity(fields: ['title'], message: 'Product title must be unique')]
//#[ORM\UniqueConstraint(name: 'title_unique_idx', columns: ['title'])]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 255, unique: true)]
    private string $title;

    #[ORM\Column]
    private int $price;

    #[ORM\Column(length: 3)]
    private string $currency;

    public function __construct(
        int $id,
        string $title,
        int $price,
        string $currency,
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->price = $price;
        $this->currency = $currency;
    }
}
