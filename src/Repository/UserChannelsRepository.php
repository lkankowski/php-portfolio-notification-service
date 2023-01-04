<?php

namespace App\Repository;

use App\Entity\UserChannels;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserChannels>
 *
 * @method UserChannels|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserChannels|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserChannels[]    findAll()
 * @method UserChannels[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserChannelsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserChannels::class);
    }

    public function save(UserChannels $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserChannels $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
