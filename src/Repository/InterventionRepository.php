<?php

namespace App\Repository;

use App\Entity\Customer;
use App\Entity\Intervention;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Intervention>
 *
 * @method Intervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method Intervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method Intervention[]    findAll()
 * @method Intervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Intervention::class);
    }

    public function add(Intervention $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Intervention $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Intervention[] Returns an array of Intervention objects
     */
    public function getCountIntervention($value): array
    {
        return $this->createQueryBuilder('i')
            ->select('count(i.id)')
            ->andWhere('i.user = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleResult();
    }
    /**
     * @return Intervention[] Returns an array of Intervention objects
     */
    public function getCountInterventionByMonth(User $user, $customer = NULL ): array
    {
        return $this->createQueryBuilder('i')
            ->select('count(i.id) as nbIntervention, MONTH(i.date) AS month')
            ->andWhere('i.user = :val')
            ->andWhere('i.customer = :custo')
            ->setParameter('val', $user)
            ->setParameter('custo', $customer)
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            // ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Intervention
    //    {
    //        return $this->createQueryBuilder('i')
    //            ->andWhere('i.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
