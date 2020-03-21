<?php

namespace App\Repository;

use App\Entity\MailType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;

/**
 * @method MailType|null find($id, $lockMode = null, $lockVersion = null)
 * @method MailType|null findOneBy(array $criteria, array $orderBy = null)
 * @method MailType[]    findAll()
 * @method MailType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MailTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MailType::class);
    }

    public function findAllOrdered(): array
    {
        return $this->findBy([], [
            'displayOrder' => 'ASC'
        ]);
    }

    public function save(MailType $mailType): void
    {
        try {
            $this->getEntityManager()->persist($mailType);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw $e;
        }
    }

    public function delete(MailType $mailType): void
    {
        try {
            $this->getEntityManager()->remove($mailType);
            $this->getEntityManager()->flush();
        } catch (ORMException $e) {
            throw $e;
        }
    }
}
