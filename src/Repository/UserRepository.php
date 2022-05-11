<?php


namespace App\Repository;
use App\Entity\Challenge;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Response;
use Symfony\Component\Serializer\SerializerInterface;
/**
* @method User|null find($id, $lockMode = null, $lockVersion = null)
* @method User|null findOneBy(array $criteria, array $orderBy = null)
* @method User[]    findAll()
* @method User[]    findBy(array $criteria,array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function authentification ($mail,$password)
    {
        $entityManager= $this->getEntityManager();
        $query=$entityManager
            ->createQuery("Select user from App\ENTITY\User user where user.mailuser =: mail AND user.password =: password  ")
            ->setParameter('mail',$mail)
            ->setParameter('password',$password);
     return $query->getResult();
    }

}