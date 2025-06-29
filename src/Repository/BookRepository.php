<?php

namespace App\Repository;

use App\Entity\Book;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Constraints\Date;

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

public function GetbookByEmail(string $email,string $username)
{
    return $this->createQueryBuilder('b')
    ->join('b.author','a')
    ->where('a.email = :email')
    ->andWhere('a.username = :username')
    ->setParameter('email', $email)
    ->setParameter('username', $username)
    ->getQuery()
    ->getResult();
}

public function CountAllBooksRomance()
{
    return $this->getEntityManager()
    ->createQuery('select count(b) from App\Entity\Book b where b.category="Romance"')
    ->getSingleScalarResult();
}


public function DisplayBooks(Date $date1,Date $date2)
{
    return $this->createQueryBuilder('b')
    ->where('b.publicationDate >=:date1')
    ->andWhere('b.publicationDate <=:date2')
    ->setParameter('date1', $date1)
    ->setParameter('date2', $date2)
    ->getQuery()
    ->getResult();
}

public function SearchById(int $id)
{
    return $this->createQueryBuilder('b')
    ->where('b.id = :id')
    ->setParameter('id','%'.$id.'%')
    ->getQuery()
    ->getResult();
}





}
