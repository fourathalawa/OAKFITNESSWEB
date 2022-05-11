<?php


namespace App\Repository;
use App\Entity\Challenge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Response;

/**
 * @method Challenge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Challenge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Challenge[]    findAll()
 * @method Challenge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChallengeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Challenge::class);
    }
    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function getChallenge ($id)
    {
        $entityManager= $this->getEntityManager();
        $query=$entityManager
            ->createQuery("Select c from App\ENTITY\CHALLENGE c where c.iduser =:id ")
            ->setParameter('id',$id);
        return $query->getResult();
    }

}