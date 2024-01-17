<?php

namespace App\Repository;

use App\Entity\ModePaiement;
use App\Entity\Utilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModePaiement>
 *
 * @method ModePaiement|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModePaiement|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModePaiement[]    findAll()
 * @method ModePaiement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModePaiementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, ModePaiement::class);
        $this->entityManager = $entityManager;
    }

    public function save(ModePaiement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ModePaiement $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.id_mode_paiement', 'm.libelle')
            ->getQuery()
            ->getResult();
    }

    public function getModePaiementWithUtilisateurs(int $value): array
    {
        $queryBuilder = $this->createQueryBuilder('m')
            ->leftJoin('m.id_utilisateur', 'u')
            ->select('m.libelle', 'u.id_utilisateur')
            ->andWhere('m.id_mode_paiement = :val')
            ->setParameter('val', $value)
            ->getQuery();

        return $queryBuilder->getResult();
    }

    public function add(array $data): void
    {
        $user = new ModePaiement();
        $user->setLibelle($data['libelle']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function addPaymentToUser(Utilisateur $user, ModePaiement $paiement): void
    {
        $user->addModePaiement($paiement);
        $this->entityManager->flush();
    }

    public function update(ModePaiement $modePaiement, string $newLibelle): void
    {
        $modePaiement->setLibelle($newLibelle);
        $this->entityManager->flush();
    }

    public function removePaymentFromUser(Utilisateur $user, ModePaiement $paiement): void
    {
        $user->removeModePaiement($paiement);
        $this->entityManager->flush();
    }

    public function removeModePaiement(ModePaiement $paiement): void
    {
        $this->entityManager->remove($paiement);
        $this->entityManager->flush();
    }

    //    /**
    //     * @return ModePaiement[] Returns an array of ModePaiement objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?ModePaiement
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
