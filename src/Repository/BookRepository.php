<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PDO;

/**
 * @extends ServiceEntityRepository<Book>
 */
class BookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Book::class);
    }

    //    /**
    //     * @return Book[] Returns an array of Book objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Book
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    public function findRandomBooks(int $limit = 5): array
    {
        $conn = $this->getEntityManager()->getConnection();

        // Requête SQL native
        $sql = 'SELECT*, firstname AS author_firstname, lastname AS author_lastname
        FROM book
        INNER JOIN author ON book.author_id = author.id
        ORDER BY RAND()
        LIMIT 5';

        // Exécuter la requête avec executeQuery et fournir directement le paramètre
        $stmt = $conn->executeQuery($sql, ['limit' => $limit]);

        // Retourner les résultats en tant que tableau associatif
        return $stmt->fetchAllAssociative();
    }
    
}
