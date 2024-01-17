<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Produit;
use App\Entity\Categorie;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

class ImageController extends AbstractController
{
    #[Route('/api/image', name: 'getAllImage', methods: ['GET'])]

    public function index(ImageRepository $imageRepository, SerializerInterface $serializer): JsonResponse
    {
        $images = $imageRepository->findAll();
        $jsonImages = $serializer->serialize($images, 'json');
        return new JsonResponse($jsonImages, Response::HTTP_OK, [], true);
    }


    #[Route('/api/image/{id}', name: 'getOneImage', methods: ['GET'])]

    public function getOneImage(Image $image, SerializerInterface $serializer): JsonResponse
    {
        $jsonImage = $serializer->serialize($image, 'json');
        return new JsonResponse($jsonImage, Response::HTTP_OK, ['accept' => 'json'], true);
    }


    #[Route('/api/image', name: 'addImage', methods: ['POST'])]
    public function addImage(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        
        $data = json_decode($request->getContent(), true);
        
        $image = new Image();

        $idCategorie = $data['id_categorie'];
        $idProduit = $data['id_produit'];
        $lienImage = $data['lien_image'];

   
        $categorie = $entityManager->getRepository(Categorie::class)->find($idCategorie);
        $produit = $entityManager->getRepository(Produit::class)->find($idProduit);


        $image->setIdCategorie($categorie);
        $image->setIdProduit($produit);
        $image->setLienImage($lienImage);

       
        $entityManager->persist($image);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Image ajoutée avec succès'], JsonResponse::HTTP_CREATED);
    }


}
