<?php

namespace App\Eshop\Infrastructure\DataFixtures;

use App\Eshop\Domain\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $product1 = new Product(1, 'Fallout', '1.99', 'USD');
        $product2 = new Product(2, 'Don’t Starve', '2.99', 'USD');
        $product3 = new Product(3, 'Baldur’s Gate', '3.99', 'USD');
        $product4 = new Product(4, 'Icewind Dale', '4.99', 'USD');
        $product5 = new Product(5, 'Bloodborne', '5.99', 'USD');
        $manager->persist($product1);
        $manager->persist($product2);
        $manager->persist($product3);
        $manager->persist($product4);
        $manager->persist($product5);

        $manager->flush();
    }
}
