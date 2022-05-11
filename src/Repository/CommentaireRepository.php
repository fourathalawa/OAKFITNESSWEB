<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function findByExampleField($value)
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb
            ->select('count(course.id)')
            ->from('CRMPicco\Component\Course\Model\Course', 'course')
        ;

        $query = $qb->getQuery();

        return $query->getSingleScalarResult();
    }

    public function countlikes($value)
    {
        $entityManager=$this->getEntityManager();
        $query=$entityManager
            ->createQuery('SELECT count(p) FROM APP\Entity\Notecommentaire p WHERE p.idNote = :id')
            ->setParameter('id',$value);
        return $query->getSingleScalarResult();
    }

    /*
    public function findOneBySomeField($value): ?Classroom
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}