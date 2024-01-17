<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class CategorieController extends AbstractController
{

    #[Route('/api/categories', name: 'getAllCategories', methods: ['GET'])]
    public function getAllCategories(CategorieRepository $categorieRepository, SerializerInterface $serializer): JsonResponse
    {
        $categories = $categorieRepository->findAll();
        $jsonCategories = $serializer->serialize($categories, 'json', ['groups' => 'category']);
        return new JsonResponse($jsonCategories, Response::HTTP_OK, [], true);
    }


    #[Route('/api/categories/{id}', name: 'getOneCategorie', methods: ['GET'])]
    public function getOneCategorie(Categorie $categorie, SerializerInterface $serializer): JsonResponse
    {
        $jsonCategorie = $serializer->serialize($categorie, 'json', ['groups' => 'category']);
        return new JsonResponse($jsonCategorie, Response::HTTP_OK, ['accept' => 'json'], true);
    }



    #[Route('/api/categories', name: 'createCategorie', methods: ['POST'])]
    public function createCategorie(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $categorie = new Categorie();
        $categorie->setNomCategorie($data['nom_categorie']);

        $entityManager->persist($categorie);
        $entityManager->flush();


        return new JsonResponse(['message' => 'Catégorie ajoute avec succes'], Response::HTTP_CREATED);
    }

    #[Route('/api/categories/{id}', name: 'updateCategorie', methods: ['PUT'])]
    public function updateCategorie(Request $request, EntityManagerInterface $entityManager, Categorie $categorie): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $categorie->setNomCategorie($data['nom_categorie']);

        $entityManager->flush();

        return new JsonResponse(['message' => 'Catégorie mise à jour avec succès'], Response::HTTP_OK);
    }


    #[Route('/api/categories/{id}', name: 'deleteCategorie', methods: ['DELETE'])]
    public function deleteCategorie(EntityManagerInterface $entityManager, Categorie $categorie): JsonResponse
    {
        $entityManager->remove($categorie);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Catégorie supprimée avec succès'], Response::HTTP_OK);
    }

    #[Route('/api/categories/multiple/{ids}', name: 'deleteCategories', methods: ['DELETE'])]
    public function deleteCategories(EntityManagerInterface $entityManager, string $ids): JsonResponse
    {
        $categorieIds = explode(',', $ids);

        $deletedCategories = [];
        foreach ($categorieIds as $categorieId) {
            $categorie = $entityManager->getRepository(Categorie::class)->find($categorieId);
            if ($categorie) {
                $entityManager->remove($categorie);
                $deletedCategories[] = $categorie->getIdCategorie();
            }
        }

        $entityManager->flush();

        return new JsonResponse(['message' => 'Catégories supprimées avec succès', 'deletedIds' => $deletedCategories], Response::HTTP_OK);
    }
}
