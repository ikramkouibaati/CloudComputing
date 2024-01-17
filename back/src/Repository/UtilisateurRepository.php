<?php

namespace App\Repository;

use App\Entity\Utilisateur;
use App\Entity\Role;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Utilisateur>
 *
 * @method Utilisateur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Utilisateur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Utilisateur[]    findAll()
 * @method Utilisateur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UtilisateurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, Utilisateur::class);
        $this->entityManager = $entityManager;
    }

    public function save(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Utilisateur $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getAll(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u.id_utilisateur', 'u.nom', 'u.prenom', 'u.email', 'u.mot_de_passe', 'u.telephone', 'r.role')
            ->join('u.id_role', 'r')
            ->getQuery()
            ->getResult();
    }

    public function getOne(int $id): ?Utilisateur
    {
        return $this->find($id);
    }

    public function add(array $data): void
    {
        $user = new Utilisateur();
        $user->setNom($data['nom']);
        $user->setPrenom($data["prenom"]);
        $user->setEmail($data['email']);
        $user->setMotDePasse(password_hash($data['mdp'], PASSWORD_DEFAULT));
        $user->setTelephone("");
        $user->setToken($data['token']);
        $user->setIdRole($this->entityManager->find(Role::class, 2));

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function login(string $email, string $password): ?Utilisateur
    {
        $user = $this->createQueryBuilder('u')
            ->andWhere('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();

        if (!$user) {
            return null;
        }

        if (!password_verify($password, $user->getMotDePasse())) {
            return null;
        }

        return $user;
    }

    public function update(Utilisateur $user, array $data): void
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'email':
                    $user->setEmail($value);
                    break;
                case 'mdp':
                    $user->setMotDePasse(password_hash($value, PASSWORD_DEFAULT));
                    break;
                case 'nom':
                    $user->setNom($value);
                    break;
                case 'prenom':
                    $user->setPrenom($value);
                    break;
                case 'tel':
                    $user->setTelephone($value);
                    break;
            }
        }
        $this->entityManager->flush();
    }

    public function delete(Utilisateur $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }



public function getLoggedInUser(int $id_utilisateur): ?Utilisateur
{
    return $this->getLoggedInUserById($id_utilisateur);
}





    //    /**
    //     * @return Utilisateur[] Returns an array of Utilisateur objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('u.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Utilisateur
    //    {
    //        return $this->createQueryBuilder('u')
    //            ->andWhere('u.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
