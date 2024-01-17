<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\ModePaiement;
use App\Repository\ModePaiementRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ModePaiementController extends AbstractController
{
    #[Route('/api/mode_paiement', name: 'getAll', methods: ['GET'])]
    public function getAll(ModePaiementRepository $paiementRepository): JsonResponse
    {
        $query = $paiementRepository->getAll();

        return $this->json($query, Response::HTTP_OK, []);
    }

    #[Route('/api/mode_paiement/{id}', name: 'get_one_mode_paiement', methods: ['GET'])]
    public function getOneModePaiement(ModePaiementRepository $modePaiementRepository, SerializerInterface $serializer, int $id): JsonResponse
    {
        $modePaiements = $modePaiementRepository->getModePaiementWithUtilisateurs($id);
        $serializedData = $serializer->serialize($modePaiements, 'json');

        return new JsonResponse($serializedData, Response::HTTP_OK, [], true);
    }

    #[Route('/api/mode_paiement', name: 'add_mode_paiement', methods: ['POST'])]
    public function addModePaiement(Request $request, ModePaiementRepository $modePaiementRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        if ($modePaiementRepository->findOneBy(['libelle' => $data['libelle']])) {
            return new Response('Mode de paiement existe déjà dans la base', Response::HTTP_NOT_FOUND);
        }

        $modePaiementRepository->add($data);

        return new Response('Mode de paiement ajouté avec succès', Response::HTTP_OK);
    }

    #[Route('/api/mode_paiement/user', name: 'add_user_mode_paiement', methods: ['POST'])]
    public function addUserModePaiement(Request $request, ModePaiementRepository $modePaiementRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $utilisateurRepository->find($data['user']);
        $paiement = $modePaiementRepository->find($data['modePaiement']);

        if (!$user || !$paiement) {
            return new Response('Utilisateur et/ou Paiement n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $modePaiementRepository->addPaymentToUser($user, $paiement);

        return new Response('Ajouté à la table asso_utilisateur_paiement', Response::HTTP_OK);
    }

    #[Route('/api/mode_paiement/{id}', name: 'update_mode_paiement', methods: ['PUT'])]
    public function updateModePaiement(int $id, Request $request, ModePaiementRepository $modePaiementRepository): Response
    {
        $modePaiement = $modePaiementRepository->find($id);

        if (!$modePaiement) {
            return new Response('Mode de paiement non trouvé', Response::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['libelle']) && $data['libelle'] != null) {
            $newLibelle = $data['libelle'];
            $modePaiementRepository->update($modePaiement, $newLibelle);
            return new Response('Mode de paiement modifié avec succès', Response::HTTP_OK);
        }

        return new Response('Paramètre "libelle" manquant', Response::HTTP_BAD_REQUEST);
    }

    #[Route('/api/mode_paiement/user', name: 'delete_user_mode_paiement', methods: ['DELETE'])]
    public function deleteUserModePaiement(Request $request, ModePaiementRepository $modePaiementRepository, UtilisateurRepository $utilisateurRepository): Response
    {
        $data = json_decode($request->getContent(), true);

        $user = $utilisateurRepository->find($data['user']);
        $paiement = $modePaiementRepository->find($data['modePaiement']);

        if (!$user || !$paiement) {
            return new Response('Utilisateur et/ou Paiement n\'existe pas', Response::HTTP_NOT_FOUND);
        }

        $modePaiementRepository->removePaymentFromUser($user, $paiement);

        $message = 'Mode de paiement supprimé pour l\'utilisateur n°' . $user->getIdUtilisateur();

        return new Response($message, Response::HTTP_OK);
    }

    #[Route('/api/mode_paiement/{id}', name: 'delete_mode_paiement', methods: ['DELETE'])]
    public function deleteModePaiement(ModePaiementRepository $modePaiementRepository, int $id): Response
    {
        $mode_paiement = $modePaiementRepository->findOneBy(['id_mode_paiement' => $id]);

        if (!$mode_paiement) {
            return new Response('Mode de paiement n\'existe pas', Response::HTTP_CONFLICT);
        }

        $modePaiementRepository->removeModePaiement($mode_paiement);

        return new Response('Mode de paiement supprimé', Response::HTTP_OK);
    }
}
