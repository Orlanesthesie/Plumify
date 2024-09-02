<?php

namespace App\Controller;

use App\Entity\Author;
use App\Entity\Book;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    private $client;
    private $entityManager;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    public function downloadJson(): Response
    {
        // URL de l'API
        $url = 'https://freetestapi.com/api/v1/books';

        // Envoyer la requête GET pour récupérer les données du fichier JSON
        $response = $this->client->request('GET', $url);

        // Vérifier que la requête a réussi
        if ($response->getStatusCode() === 200) {
            // Récupérer le contenu JSON
            $jsonContent = $response->getContent();

            // Définir le chemin de sauvegarde dans le répertoire public
            $projectDir = $this->getParameter('kernel.project_dir');
            $filePath = $projectDir . '/public/assets/data.json';

            // Créer le dossier si nécessaire
            if (!is_dir(dirname($filePath))) {
                mkdir(dirname($filePath), 0755, true);
            }

            // Sauvegarder le contenu dans un fichier local
            file_put_contents($filePath, $jsonContent);

            // Retourner une réponse pour confirmer que le fichier a été téléchargé
            return new JsonResponse(['status' => 'success', 'message' => 'Fichier JSON téléchargé avec succès.']);
        }

        // Gérer le cas où la requête a échoué
        return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors du téléchargement du fichier JSON.']);
    }

    #[Route('/import-json', name: 'import_json')]
    public function importJsonToDatabase(): Response
    {
        // Chemin du fichier JSON
        $projectDir = $this->getParameter('kernel.project_dir');
        $filePath = $projectDir . '/public/assets/data.json';

        // Vérifier que le fichier existe
        if (!file_exists($filePath)) {
            return new JsonResponse(['status' => 'error', 'message' => 'Fichier JSON non trouvé.']);
        }

        // Lire le contenu du fichier
        $jsonContent = file_get_contents($filePath);

        // Décoder le JSON en tableau associatif PHP
        $data = json_decode($jsonContent, true);

        if ($data === null) {
            return new JsonResponse(['status' => 'error', 'message' => 'Erreur lors du décodage du fichier JSON.']);
        }

        // Initialisation des tableaux pour stocker les auteurs et les livres
        $authors = [];
        $books = [];

        // Parcourir les éléments et les enregistrer dans la base de données
        foreach ($data as $item) {
            // Normaliser le nom de l'auteur
            $authorName = trim($item['author']);
            $authorNameParts = explode(' ', $authorName);
            $firstname = ucfirst(strtolower(trim($authorNameParts[0])));
            $lastname = ucfirst(strtolower(trim($authorNameParts[1] ?? '')));

            // Rechercher ou créer l'auteur
            $author = $this->entityManager->getRepository(Author::class)
                ->findOneBy(['lastname' => $lastname, 'firstname' => $firstname]);

            if (!$author) {
                // Si l'auteur n'existe pas, le créer
                $author = new Author();
                $author->setFirstname($firstname);
                $author->setLastname($lastname);
                $this->entityManager->persist($author);
                $authors[] = $author;
            }

            // Vérifier si le livre existe déjà pour cet auteur
            $existingBook = $this->entityManager->getRepository(Book::class)
                ->findOneBy(['title' => $item['title'], 'author' => $author]);

            if (!$existingBook) {
                // Créer le livre seulement s'il n'existe pas déjà
                $book = new Book();
                $book->setTitle($item['title']);
                $book->setPublicationYear($item['publication_year']);
                $book->setDescription($item['description']);
                $book->setCoverImage($item['cover_image']);
                $book->setAuthor($author);
                // Ajouter les catégories au livre
                foreach ($item['genre'] as $genreName) {
                    $category = $this->entityManager->getRepository(Category::class)
                    ->findOneBy(['name' => $item['genre']]);
                    if (!$category) {
                        $category = new Category();
                        $category->setName($genreName);
                        $this->entityManager->persist($category);
                    }
                    $book->addCategory($category);
                }

                $this->entityManager->persist($book);
                $books[] = $book;
            }
        }

        // Exécuter l'enregistrement en base de données
        $this->entityManager->flush();

        // Mise à jour des IDs des livres pour chaque auteur
        foreach ($authors as $author) {
            $author->updateBooksIds();
            $this->entityManager->persist($author);
        }

        // Sauvegarde des auteurs avec leurs booksIds mis à jour
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Les données JSON ont été importées dans la base de données avec succès.']);
    }
}
