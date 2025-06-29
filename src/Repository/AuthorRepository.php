<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

//    /**
//     * @return Author[] Returns an array of Author objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Author
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

//DQL (afficage(Query builder) ou bien suppression ou bien modification)

public function findByUsernameAndEmail(string $username,string $email)
{
    return $this->getEntityManager()
    ->createQuery('select a from App\Entity\Author a where a.username=:username and a.email=:email')
    ->setParameter('username', $username)
    ->setParameter('email', $email)
    ->getResult();
} 

//QueryBuilder(affichage)

public function findByUsernameAndEmail2(string $username,string $email)
{
    return $this->createQueryBuilder('a')
    ->where('a.username = :username')
    ->andWhere('a.email = :email')
    ->setParameter('username', $username)
    ->setParameter('email', $email)
    ->getQuery()
    ->getResult();
}

public function DeleteWhereNbBookZero()
{
    return $this->getEntityManager()
    ->createQuery('delete from App\Entity\Author a where a.nb_books=0')
    ->execute();
}

public function listAuthorByEmail()
{
    return $this->createQueryBuilder('a')
    ->orderBy('a.email','DESC')
    ->getQuery()
    ->getResult();
}




}
