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


    public function findPopularBooks()
    {
        return $this->createQueryBuilder('b')
            ->join('b.likedByUsers', 'bu')
            ->groupBy('b.id')
            ->orderBy('COUNT(bu)', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    // SELECT book.*, COUNT(book_user.book_id) as count_likes FROM book 
    // JOIN book_user
    // ON book_user.book_id = book.id
    // GROUP BY book.id
    // ORDER BY count_likes DESC;

}
