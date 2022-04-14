<?php


namespace App\Repository;
class ChallengeRepository
{
public function getChallenge ($id)
{
    $entityManager= $this->getEntityManager();
    $query=$entityManager
        ->createQuery("Select c from App\ENTITY\CHALLENGE c where c.IdUser =:id ")
        ->setParameter('id',$id);
    return $query->getResult();

}
}