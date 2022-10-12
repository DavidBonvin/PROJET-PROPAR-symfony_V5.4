<?php

namespace App\Repository;

use App\Entity\Commande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commande>
 *
 * @method Commande|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commande|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commande[]    findAll()
 * @method Commande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commande::class);
    }

    public function add(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Commande[] Returns an array of Commande objects
     */
    public function findOperationUserEncours($id): array
    {
        return $this->createQueryBuilder('m')
            ->where("m.statut = ?1")
            ->andWhere("m.user = ?2")
            ->setParameter(1, "En cours")
            ->setParameter(2, $id)
            ->orderBy('m.date', 'DESC')
            ->getQuery()
            ->getResult();
        // ->setMaxResults(10)

    }
    public function findUserCompteur($id)
    {
        return $this->createQueryBuilder('m')
            ->where("m.statut = ?1")
            ->andWhere("m.user = ?2")
            ->setParameter(1, "En cours")
            ->setParameter(2, $id)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleField(): array
    {
        return $this
            ->createQueryBuilder('Commande')
            ->select('Commande.prix')
            ->from('App\Entity\Commande', 'c')
            ->from('App\Entity\Operation', 'o')
            ->where("c.operationId = ?1")
            ->andWhere("Commande.statut = ?2")
            ->setParameter(1, "o.id")
            ->setParameter(2, "En cours")
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Commande
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
