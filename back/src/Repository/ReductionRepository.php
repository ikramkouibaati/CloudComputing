<?php

namespace App\Repository;

use App\Entity\Reduction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reduction>
 *
 * @method Reduction|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reduction|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reduction[]    findAll()
 * @method Reduction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReductionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Reduction::class);
        $this->entityManager = $entityManager;
    }

    public function save(Reduction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reduction $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.id_reduction', 'r.code_promo', 'r.pourcentage', 'r.actif', 'r.date_debut', 'r.date_fin')
            ->getQuery()
            ->getResult();
    }

    public function getOne($id): ?Reduction
    {
        return $this->entityManager->getRepository(Reduction::class)->find($id);
    }

    public function findByCode(string $code): ?Reduction
    {
        return $this->entityManager->getRepository(Reduction::class)->findOneBy(['code_promo' => $code]);
    }

    public function add(array $data): Reduction
    {
        $reduction = new Reduction();
        $reduction->setCodePromo($data['code_promo']);
        $reduction->setPourcentage($data['pourcentage']);
        $reduction->setActif($data['actif']);
        $reduction->setDateDebut(new \DateTime($data['date_debut']));
        $reduction->setDateFin(new \DateTime($data['date_fin']));

        $this->entityManager->persist($reduction);
        $this->entityManager->flush();

        return $reduction;
    }

    public function update(Reduction $reduction, array $data): void
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'code_promo':
                    $reduction->setCodePromo($value);
                    break;
                case 'pourcentage':
                    $reduction->setPourcentage($value);
                    break;
                case 'actif':
                    $reduction->setActif($value);
                    break;
                case 'date_debut':
                    $reduction->setDateDebut(new \DateTime($value));
                    break;
                case 'date_fin':
                    $reduction->setDateFin(new \DateTime($value));
                    break;
            }
        }
        $this->entityManager->flush();
    }

    public function delete(int $id): void
    {
        $reduction = $this->find($id);

        if ($reduction) {
            $this->entityManager->remove($reduction);
            $this->entityManager->flush();
        }
    }

    //    /**
    //     * @return Reduction[] Returns an array of Reduction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reduction
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
