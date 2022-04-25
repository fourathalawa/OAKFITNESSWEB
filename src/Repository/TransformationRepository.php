<?php

namespace App\Repository;
use App\Entity\Transformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Response;

/**
 * @method Transformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transformation[]    findAll()
 * @method Transformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 *
 */
class TransformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transformation::class);
    }
/*
    public function voteTransformation($id)
    {
        $entityManager= $this->getEntityManager();
        $entityManager
            ->createQuery("UPDATE transformation SET Tlike=Tlike+1 WHERE IdImage = :id")
            ->setParameter('id',$id)->execute();
    }*/

}