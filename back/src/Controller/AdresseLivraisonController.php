<?php

namespace App\Controller;

use App\Entity\AdresseLivraison;
use App\Entity\AssoAdresseLivraisonUtilisateur;
use App\Repository\AdresseLivraisonRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Utilisateur;

class AdresseLivraisonController extends AbstractController
{
    #[Route('/api/adresses_livraison', name: 'getAdressesLivraison', methods: ['GET'])]

    public function getAdressesLivraison(AdresseLivraisonRepository $adresseLivraisonRepository, SerializerInterface $serializer): JsonResponse
    {
        $query = $adresseLivraisonRepository->createQueryBuilder('a')
            ->select('a.id_adresse_livraison ', 'a.rue', 'a.complement_adresse', 'a.region', 'a.ville', 'a.code_postal', 'a.pays');

        $adressesLivraison = $query->getQuery()->getResult();

        $json = $serializer->serialize($adressesLivraison, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }


    #[Route('/api/adresses_livraisonUser', name: 'getAdressesLivraisonUser', methods: ['GET'])]
    public function getAdressesLivraisonUser(AdresseLivraisonRepository $adresseLivraisonRepository, SerializerInterface $serializer, UtilisateurRepository $userRepository, Request $request): JsonResponse
    {
       
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
    
        if (!$token) {
            return new JsonResponse(['message' => 'Token non fourni'], Response::HTTP_BAD_REQUEST);
        }
    
        $user = $userRepository->findOneBy(['token' => $token]);
    
        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], Response::HTTP_UNAUTHORIZED);
        }
    
        $query = $adresseLivraisonRepository->createQueryBuilder('al')
            ->select('al.id_adresse_livraison', 'al.rue', 'al.complement_adresse', 'al.region', 'al.ville', 'al.code_postal', 'al.pays')
            ->leftJoin('al.utilisateurs', 'u')
            ->where('u.id_utilisateur = :userId')
            ->setParameter('userId', $user->getIdUtilisateur());
    
        $adressesLivraison = $query->getQuery()->getResult();
    
        $json = $serializer->serialize(['user' => $user->serialize(), 'adressesLivraison' => $adressesLivraison], 'json');
    
        return new JsonResponse($json, JsonResponse::HTTP_OK, ['Content-Type' => 'application/json'], true);
    }
    




    #[Route('/api/adresses_livraison/{id}', name: 'getAdresseLivraisonById', methods: ['GET'])]

    public function getAdresseLivraisonById(int $id, AdresseLivraisonRepository $adresseLivraisonRepository, SerializerInterface $serializer): JsonResponse
    {
        $queryBuilder = $adresseLivraisonRepository->createQueryBuilder('a')
            ->select('a.id_adresse_livraison', 'a.rue', 'a.complement_adresse', 'a.region', 'a.ville', 'a.code_postal', 'a.pays')
            ->andWhere('a.id_adresse_livraison = :id')
            ->setParameter('id', $id)
            ->getQuery();

        $adresseLivraison = $queryBuilder->getOneOrNullResult();
        $jsonAdresseLivraison = $serializer->serialize($adresseLivraison, 'json');

        return new JsonResponse($jsonAdresseLivraison, JsonResponse::HTTP_OK, ['Content-Type' => 'application/json'], true);
    }




    #[Route('/api/adresses_livraison', name: 'createAdresseLivraison', methods: ['POST'])]
    public function createAdresseLivraison(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $userRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
    
        if (!$token) {
            return new JsonResponse('Token non fourni', Response::HTTP_BAD_REQUEST);
        }
    
       
        $user = $userRepository->findOneBy(['token' => $token]);
    
        if (!$user) {
            return new JsonResponse('Utilisateur non trouvé', Response::HTTP_NOT_FOUND);
        }
    
        $adresseLivraison = new AdresseLivraison();
        $adresseLivraison->setRue($data['rue']);
        $adresseLivraison->setComplementAdresse($data['complement_adresse']);
        $adresseLivraison->setRegion($data['region']);
        $adresseLivraison->setVille($data['ville']);
        $adresseLivraison->setCodePostal($data['code_postal']);
        $adresseLivraison->setPays($data['pays']);
        $adresseLivraison->setCarnetAdresse($data['carnet_adresse']);
    
        $entityManager->persist($adresseLivraison);
        $entityManager->flush();
    
    
        $user->addAdressesLivraison($adresseLivraison);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Adresse de livraison ajoutée avec succès'], Response::HTTP_CREATED);
    }
    

    #[Route('/api/adresses_livraison/{id}', name: 'editAdresseLivraison', methods: ['PUT'])]
    public function editAdresseLivraison(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UtilisateurRepository $userRepository
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
    
        
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));
    
        if (!$token) {
            return new JsonResponse('Token non fourni', Response::HTTP_BAD_REQUEST);
        }
    
       
        $user = $userRepository->findOneBy(['token' => $token]);
    
        if (!$user) {
            return new JsonResponse('Utilisateur non trouvé', Response::HTTP_NOT_FOUND);
        }
    
     
        $adresseLivraison = $entityManager->getRepository(AdresseLivraison::class)->find($id);
    
        if (!$adresseLivraison) {
            return new JsonResponse('Adresse de livraison non trouvée', Response::HTTP_NOT_FOUND);
        }
    
      
        $adresseLivraison->setRue($data['rue']);
        $adresseLivraison->setComplementAdresse($data['complement_adresse']);
        $adresseLivraison->setRegion($data['region']);
        $adresseLivraison->setVille($data['ville']);
        $adresseLivraison->setCodePostal($data['code_postal']);
        $adresseLivraison->setPays($data['pays']);
       
    
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Adresse de livraison mise à jour avec succès'], Response::HTTP_OK);
    }





    #[Route('/api/adresses_livraison/{id}', name: 'deleteAdresseLivraison', methods: ['DELETE'])]
    public function deleteAdresseLivraison(EntityManagerInterface $entityManager, AdresseLivraison $adresseLivraison): JsonResponse
    {
        $entityManager->remove($adresseLivraison);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Adresse de livraison supprimée avec succès'], Response::HTTP_OK);
    }
}
