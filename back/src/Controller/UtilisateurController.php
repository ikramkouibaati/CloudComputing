<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Firebase\JWT\ExpiredException;
use Lcobucci\JWT\Configuration;
use Negotiation\Exception\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Firebase\JWT\JWT;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Token;

   
class UtilisateurController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UtilisateurRepository $utilisateurRepository;

    public function __construct(EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepository)
    {
        $this->entityManager = $entityManager;
        $this->utilisateurRepository = $utilisateurRepository;
    }

    #[Route('/api/utilisateur', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $query = $this->utilisateurRepository->getAll();

        return new JsonResponse($query, Response::HTTP_OK, []);
    }

   

    #[Route('/api/utilisateur/{id}', name: 'updateUtilisateur', methods: ['PUT'])]
    public function updateUtilisateur(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->utilisateurRepository->find($id);

        if (!$user) {
            return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $this->utilisateurRepository->update($user, $data);

        return $this->json(['message' => 'Utilisateur modifié avec succès'], Response::HTTP_OK);
    }

    #[Route('/api/utilisateur/{id}', name: 'deleteUtilisateur', methods: ['DELETE'])]
    public function deleteUtilisateur(int $id): Response
    {
        $user = $this->utilisateurRepository->find($id);

        if ($user) {
            $this->utilisateurRepository->delete($user);
            return $this->json(['message' => 'User supprimé'], Response::HTTP_OK);
        } else {
            throw $this->createNotFoundException('User not found');
        }
    }
}
