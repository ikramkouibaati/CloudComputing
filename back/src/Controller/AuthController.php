<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class AuthController extends AbstractController
{
    private UtilisateurRepository $utilisateurRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
    }

  

#[Route('/api/utilisateur', name: 'addUtilisateur', methods: ['POST'])]
public function addUtilisateur(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    if ($this->utilisateurRepository->findOneBy(['email' => $data['email']])) {
        return $this->json(['message' => 'Email existe déjà dans la base'], Response::HTTP_CONFLICT);
    }

 
    $token = bin2hex(random_bytes(32));
    $data['token'] = $token;



    $this->utilisateurRepository->add($data);

    return $this->json(['message' => 'Utilisateur inscrit', 'token' => $token], Response::HTTP_OK);
}



#[Route('/api/utilisateur/login', name: 'login', methods: ['POST'])]
public function login(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (!$email || !$password) {
        return $this->json(['message' => 'Email et/ou mot de passe manquant'], Response::HTTP_BAD_REQUEST);
    }

    
    $user = $this->utilisateurRepository->findOneBy(['email' => $email]);

    if (!$user) {
        return $this->json(['message' => 'Identifiants incorrects'], Response::HTTP_UNAUTHORIZED);
    }

   
    $id = $user->getIdUtilisateur(); 

    $token = $user->getToken();

    return $this->json(['message' => 'Login successful', 'id_utilisateur' => $id, 'token' => $token], Response::HTTP_OK);
}




#[Route('/api/utilisateur/loginAdmin', name: 'loginAdmin', methods: ['POST'])]
public function loginAdmin(Request $request): JsonResponse
{
    $data = json_decode($request->getContent(), true);

    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (!$email || !$password) {
        return $this->json(['message' => 'Email et/ou mot de passe manquant'], Response::HTTP_BAD_REQUEST);
    }

  
    $user = $this->utilisateurRepository->findOneBy(['email' => $email]);

    if (!$user) {
        return $this->json(['message' => 'Identifiants incorrects'], Response::HTTP_UNAUTHORIZED);
    }



    $idRole = $user->getIdRole()->getId(); 

  
    if ($idRole !== 1) {
        return $this->json(['message' => 'Access denied.'], Response::HTTP_FORBIDDEN);
    }

    $id = $user->getIdUtilisateur(); 

    $token = $user->getToken();

    return $this->json(['message' => 'Login successful', 'id_utilisateur' => $id, 'token' => $token], Response::HTTP_OK);
}





    #[Route('/api/utilisateur/profile', name: 'profile', methods: ['GET'])]
    public function profile(Request $request): JsonResponse
    {
      
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token) {
            return $this->json(['message' => 'Token non fourni'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->utilisateurRepository->findOneBy(['token' => $token]);

        if (!$user) {
            return $this->json(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        
        return $this->json(['user' => $user->serialize()], Response::HTTP_OK);
    }

   
}


