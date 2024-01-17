<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Repository\MaterielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class MaterielController extends AbstractController
{
    #[Route('/api/materiel', name: 'getAllMateriel', methods: ['GET'])]

    public function index(MaterielRepository $materielRepository, SerializerInterface $serializer): JsonResponse
    {
        $query = $materielRepository->createQueryBuilder('m')
            ->select('m.id_materiel', 'm.nom');

        $materiels = $query->getQuery()->getResult();

        $json = $serializer->serialize($materiels, 'json');

        return new JsonResponse($json, Response::HTTP_OK, [], true);
    }



    #[Route('/api/materiel/{id}', name: 'getOneMateriel', methods: ['GET'])]
    public function getOneMateriel(Materiel $materiel, SerializerInterface $serializer): JsonResponse
    {
        $jsonProduit = $serializer->serialize($materiel, 'json', [AbstractNormalizer::GROUPS => 'materiel']);

        return new JsonResponse($jsonProduit, Response::HTTP_OK, ['accept' => 'json'], true);
    }





    #[Route('/api/materiel ', name: 'createMateriel', methods: ['POST'])]
    public function createMateriel(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);

        $materiel = new Materiel();
        $materiel->setNom($data['nom']);
      
        $entityManager->persist($materiel);
        $entityManager->flush();

       
        return new JsonResponse(['message' => 'Catégorie ajoute avec succes'], Response::HTTP_CREATED);
    }


    #[Route('/api/materiel/{id}', name: 'updateMateriel', methods: ['PUT'])]
    public function updateMateriel(Request $request, EntityManagerInterface $entityManager, Materiel $materiel): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
    
        $materiel->setNom($data['nom']);
    
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Materiel mis à jour avec succès'], Response::HTTP_OK);
    }
    


    #[Route('/api/materiel/{id}', name: 'deleteMateriel', methods: ['DELETE'])]
    public function deleteMateriel(EntityManagerInterface $entityManager, Materiel $materiel): JsonResponse
    {
        $entityManager->remove($materiel);
        $entityManager->flush();
    
        return new JsonResponse(['message' => 'Materiel supprimé avec succès'], Response::HTTP_OK);
    }
    
    



}
