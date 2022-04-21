<?php


namespace App\Repository;

use App\Entity\Notecommentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Notecommentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notecommentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notecommentaire[]    findAll()
 * @method Notecommentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotecommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notecommentaire::class);
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