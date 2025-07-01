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

// Récupère les livres écrits par un auteur spécifique identifié par son email et son username
public function GetbookByEmail(string $email, string $username)
{
    return $this->createQueryBuilder('b') // Crée un QueryBuilder pour l'entité Book avec l'alias 'b'
        ->join('b.author', 'a') // Fait une jointure avec l'entité Author via la relation 'author' de Book
        ->where('a.email = :email') // Condition : l'email de l'auteur doit correspondre au paramètre fourni
        ->andWhere('a.username = :username') // Condition supplémentaire : le username doit aussi correspondre
        ->setParameter('email', $email) // Définit la valeur du paramètre 'email'
        ->setParameter('username', $username) // Définit la valeur du paramètre 'username'
        ->getQuery() // Génère la requête
        ->getResult(); // Exécute la requête et retourne le résultat sous forme de tableau
}

// Compte le nombre total de livres appartenant à la catégorie "Romance"
public function CountAllBooksRomance()
{
    return $this->getEntityManager() // Récupère l'EntityManager
        ->createQuery('SELECT COUNT(b) FROM App\Entity\Book b WHERE b.category = "Romance"') // Crée une requête DQL pour compter les livres de catégorie Romance
        ->getSingleScalarResult(); // Retourne le résultat sous forme de valeur unique (le nombre)
}

// Affiche les livres publiés entre deux dates
public function DisplayBooks(Date $date1, Date $date2)
{
    return $this->createQueryBuilder('b') // Crée un QueryBuilder pour l'entité Book
        ->where('b.publicationDate >= :date1') // Condition : la date de publication est postérieure ou égale à date1
        ->andWhere('b.publicationDate <= :date2') // Condition : la date de publication est antérieure ou égale à date2
        ->setParameter('date1', $date1) // Définit la valeur du paramètre date1
        ->setParameter('date2', $date2) // Définit la valeur du paramètre date2
        ->getQuery() // Génère la requête
        ->getResult(); // Exécute la requête et retourne les résultats
}

// Recherche un livre par son identifiant
public function SearchById(int $id)
{
    return $this->createQueryBuilder('b') // Crée un QueryBuilder pour l'entité Book
        ->where('b.id = :id') // Condition : l'identifiant doit correspondre au paramètre
        ->setParameter('id', '%'.$id.'%') // Définit le paramètre 'id' (ceci est incorrect pour une recherche par id exact, voir remarque ci-dessous)
        ->getQuery() // Génère la requête
        ->getResult(); // Exécute la requête et retourne les résultats
}





}
