<?php

namespace App\Controller;

use App\Entity\AssoCommandeProduit;
use App\Entity\AdresseFacturation;
use App\Entity\AdresseLivraison;
use App\Entity\Commande;
use App\Entity\Utilisateur;
use App\Entity\Reduction;
use App\Repository\CommandeRepository;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;


class CommandeController extends AbstractController
{

    private UtilisateurRepository $utilisateurRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(UtilisateurRepository $utilisateurRepository, EntityManagerInterface $entityManager)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->entityManager = $entityManager;
    }



    #[Route('/api/commande', name: 'getAllCommandes', methods: ['GET'])]

    public function index(CommandeRepository $commandeRepository, SerializerInterface $serializer): JsonResponse
    {
        $query = $commandeRepository->createQueryBuilder('c')
            ->select('c.id_commande', 'u.id_utilisateur', 'c.date_commande', 'c.prix_total', 'reduc.id_reduction')
            ->leftJoin('c.id_reduction', 'reduc')
            ->join('c.id_utilisateur', 'u');

        $commandes = $query->getQuery()->getResult();

        $jsonCommande = $serializer->serialize($commandes, 'json');

        return new JsonResponse($jsonCommande, Response::HTTP_OK, [], true);
    }


    #[Route('/api/commande/{id}', name: 'getOneCommande', methods: ['GET'])]

    public function getOneCommande(Commande $commande, SerializerInterface $serializer): JsonResponse
    {
        $json = $serializer->serialize($commande, 'json', [
            'groups' => ['commande'],
        ]);

        return new JsonResponse($json, Response::HTTP_OK, ['accept' => 'json'], true);
    }


    #[Route('/api/commande', name: 'createCommande', methods: ['POST'])]
    public function createCommande(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        // Vérifie les données manquantes
        if (!isset($data['produits']) || !isset($data['id_adresse_facturation']) || !isset($data['id_adresse_livraison'])) {
            return new Response('Données manquantes', 400);
        }


        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token) {
            return new Response('Token non fourni', 400);
        }

        $user = $this->utilisateurRepository->findOneBy(['token' => $token]);

        if (!$user) {
            return new Response('Utilisateur non trouvé', 404);
        }


        $commande = new Commande();
        $commande->setIdUtilisateur($user);


        $adresseFacturation = $entityManager->getRepository(AdresseFacturation::class)->find($data['id_adresse_facturation']);
        $adresseLivraison = $entityManager->getRepository(AdresseLivraison::class)->find($data['id_adresse_livraison']);


        $commande->setIdAdresseFacturation($adresseFacturation);
        $commande->setIdAdresseLivraison($adresseLivraison);
        $commande->setDateCommande(new \DateTime());
        $commande->setPrixTotal(0);

        $entityManager->persist($commande);

        $prixTotal = 0;

        foreach ($data['produits'] as $produitData) {
            if (!isset($produitData['id_produit']) || !isset($produitData['quantite'])) {
                return new Response('Données de produit manquantes', 400);
            }

            $assoCommandeProduit = new AssoCommandeProduit();
            $assoCommandeProduit->setIdCommande($commande);
            $produit = $entityManager->getRepository(Produit::class)->find($produitData['id_produit']);
            $assoCommandeProduit->setIdProduit($produit);
            $assoCommandeProduit->setQuantite($produitData['quantite']);

            $entityManager->persist($assoCommandeProduit);

            $produit->setStock($produit->getStock() - $produitData['quantite']);

            $prixPartiel = $produit->getPrix() * $produitData['quantite'];
            $prixTotal += $prixPartiel;
        }

        $commande->setPrixTotal($prixTotal);

        $entityManager->flush();

        return new Response('Commande ajoutée avec succès', 200);
    }

    #[Route('/api/commande', name: 'getAllCommandes', methods: ['GET'])]

    public function getCommande(CommandeRepository $commandeRepository, SerializerInterface $serializer): JsonResponse
    {
        $query = $commandeRepository->createQueryBuilder('c')
            ->select('c.id_commande', 'u.id_utilisateur', 'c.date_commande', 'c.prix_total', 'reduc.id_reduction')
            ->leftJoin('c.id_reduction', 'reduc')
            ->join('c.id_utilisateur', 'u');

        $commandes = $query->getQuery()->getResult();

        $jsonCommande = $serializer->serialize($commandes, 'json');

        return new JsonResponse($jsonCommande, Response::HTTP_OK, [], true);
    }



    #[Route('/api/commandes', name: 'getCommandes', methods: ['GET'])]
    public function getCommandes(CommandeRepository $commandeRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {

        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token) {
            return new JsonResponse(['message' => 'Token non fourni'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->utilisateurRepository->findOneBy(['token' => $token]);

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }


        $query = $commandeRepository->createQueryBuilder('c')
            ->select('c.id_commande', 'u.id_utilisateur', 'c.date_commande', 'c.prix_total', 'reduc.id_reduction')
            ->leftJoin('c.id_reduction', 'reduc')
            ->join('c.id_utilisateur', 'u')
            ->where('u = :user')
            ->setParameter('user', $user);

        $commandes = $query->getQuery()->getResult();


        $jsonCommande = $serializer->serialize($commandes, 'json');

        return new JsonResponse($jsonCommande, Response::HTTP_OK, [], true);
    }

   

    #[Route('/api/commande-details', name: 'getCommandeDetails', methods: ['GET'])]
    public function getCommandeDetails(CommandeRepository $commandeRepository, SerializerInterface $serializer, Request $request): JsonResponse
    {
   
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization'));

        if (!$token) {
            return new JsonResponse(['message' => 'Token non fourni'], Response::HTTP_BAD_REQUEST);
        }

        $user = $this->utilisateurRepository->findOneBy(['token' => $token]);

        if (!$user) {
            return new JsonResponse(['message' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        
        $query = $commandeRepository->createQueryBuilder('c')
            ->select('c.id_commande', 'u.id_utilisateur', 'c.date_commande', 'c.prix_total', 'reduc.id_reduction', 'acp.quantite', 'p.id_produit', 'p.nom_produit', 'p.description', 'p.prix')
            ->leftJoin('c.id_reduction', 'reduc')
            ->join('c.id_utilisateur', 'u')
            ->leftJoin('App\Entity\AssoCommandeProduit', 'acp', 'WITH', 'c.id_commande = acp.id_commande')
            ->leftJoin('acp.id_produit', 'p')
            ->where('u = :user')
            ->setParameter('user', $user);

        $commandeDetails = $query->getQuery()->getResult();

        $jsonCommandeDetails = $serializer->serialize($commandeDetails, 'json');

        return new JsonResponse($jsonCommandeDetails, Response::HTTP_OK, [], true);
    }
}
