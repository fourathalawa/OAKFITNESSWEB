<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PhpParser\Node\Expr\Array_;

/**
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Evenement::class);
        $this->paginator = $paginator;

    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Evenement $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Evenement $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

     /**
      * @return PaginationInterface Returns an array of Evenement objects
      */

    public function filterSearch(SearchData $search): PaginationInterface
    {


        $query = $this->createQueryBuilder('e');
            if(!empty($search->q)){
                $query = $query
                    ->andWhere('e.titreevenement LIKE :q')
                    ->setParameter('q', "%{$search->q}%");
            }
            if(!empty($search->minDate)){
                $query = $query
                    ->andWhere('e.dateevenement >= :minDate')
                    ->setParameter('minDate', "{$search->minDate->format('Y-m-d')}");
            }
        if(!empty($search->maxDate)){

            $query = $query
                ->andWhere('e.dateevenement <= :maxDate')
                ->setParameter('maxDate', "{$search->maxDate->format('Y-m-d')}");
        }
        if(!empty($search->online)){
            $query = $query
                ->andWhere('e.typeevenement = :ONLINE')
            ->setParameter('ONLINE', "ONLINE");

        }
        if(!empty($search->creators)){
            $query = $query
                ->andWhere('e.idcreatorevenement IN (:creators)')
                ->setParameter('creators', $search->creators);
        }

        $query = $query->getQuery();
        return $this->paginator->paginate(
            $query,
            $search->page,
            3

        );
    }

    /**
     * @return array
     */
    public function getCreators():array
    {
        $qb = $this->createQueryBuilder('e')
            ->select('e.idcreatorevenement')
            ->distinct();
        $query = $qb->getQuery();
        return $query->execute();
    }

    /**
     * @return array
     */
    public function  get1Day():array
    {
        $date = date('Y-m-d', strtotime("+1 days"));
        $qb = $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.dateevenement = :n1Day')
            ->setParameter('n1Day', $date)
            ->getQuery()
            ->getArrayResult();
        return $qb;
    }

    /*
    public function findOneBySomeField($value): ?Evenement
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
