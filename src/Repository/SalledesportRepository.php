<?php


namespace App\Repository;
use App\Entity\Salledesport;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Salledesport|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salledesport|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salledesport[]    findAll()
 * @method Salledesport[]    findBy(array $criteria,array $orderBy = null, $limit = null, $offset = null)
 */
class SalledesportRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salledesport::class);
    }
}