<?php

namespace App\Repository;

use App\Entity\AssoAdresseFacturationUtilisateur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AssoAdresseFacturationUtilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method AssoAdresseFacturationUtilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method AssoAdresseFacturationUtilisateur[]    findAll()
 * @method AssoAdresseFacturationUtilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AssoAdresseFacturationUtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AssoAdresseFacturationUtilisateur::class);
    }

    public function save(AssoAdresseFacturationUtilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AssoAdresseFacturationUtilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
