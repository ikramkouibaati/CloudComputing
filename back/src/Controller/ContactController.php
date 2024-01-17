<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContactController extends AbstractController
{

    #[Route('/api/contact', name: 'getAllContact', methods: ['GET'])]
    public function index(ContactRepository $contactRepository, SerializerInterface $serializer): JsonResponse
    {
        $contacts = $contactRepository->getAll();

        $jsonContacts = $serializer->serialize($contacts, 'json');

        return new JsonResponse($jsonContacts, Response::HTTP_OK, [], true);
    }


    #[Route('/api/contact/{id}', name: 'getOneContact', methods: ['GET'])]
    public function getOneContact(ContactRepository $contactRepository, int $id): JsonResponse
    {
        $contact = $contactRepository->getOne($id);

        $jsonContact = $contact->serialize();

        return $this->json($jsonContact, Response::HTTP_OK);
    }

    #[Route('/api/contact/create', name: 'createContact', methods: ['POST'])]
    public function createContact(Request $request, ContactRepository $contactRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $utilisateur = $entityManager->getReference(Utilisateur::class, $data['id_client']);

        $contactRepository->create($data, $utilisateur);

        return $this->json(['message' => 'Contact Form crée avec succès'], Response::HTTP_CREATED);
    }
}
