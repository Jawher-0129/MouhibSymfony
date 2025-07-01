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

// Recherche un auteur par son nom d'utilisateur et son email (en utilisant DQL)
public function findByUsernameAndEmail(string $username, string $email)
{
    return $this->getEntityManager() // Récupère l'EntityManager
        ->createQuery('SELECT a FROM App\Entity\Author a WHERE a.username = :username AND a.email = :email') // Crée une requête DQL pour chercher un auteur avec un username et un email spécifiques
        ->setParameter('username', $username) // Assigne la valeur du paramètre :username
        ->setParameter('email', $email) // Assigne la valeur du paramètre :email
        ->getResult(); // Exécute la requête et retourne les résultats (liste d’auteurs correspondants)
}

// Recherche un auteur par son nom d'utilisateur et son email (en utilisant QueryBuilder)
public function findByUsernameAndEmail2(string $username, string $email)
{
    return $this->createQueryBuilder('a') // Crée un QueryBuilder sur l'entité Author avec l'alias 'a'
        ->where('a.username = :username') // Ajoute une condition sur le champ username
        ->andWhere('a.email = :email') // Ajoute une condition sur le champ email
        ->setParameter('username', $username) // Définit la valeur du paramètre username
        ->setParameter('email', $email) // Définit la valeur du paramètre email
        ->getQuery() // Génère la requête
        ->getResult(); // Exécute la requête et retourne les résultats
}

// Supprime tous les auteurs qui ont un nombre de livres (nb_books) égal à 0
public function DeleteWhereNbBookZero()
{
    return $this->getEntityManager() // Récupère l'EntityManager
        ->createQuery('DELETE FROM App\Entity\Author a WHERE a.nb_books = 0') // Crée une requête DQL pour supprimer les auteurs avec nb_books = 0
        ->execute(); // Exécute la requête de suppression
}

// Liste tous les auteurs triés par leur email en ordre décroissant
public function listAuthorByEmail()
{
    return $this->createQueryBuilder('a') // Crée un QueryBuilder pour l'entité Author
        ->orderBy('a.email', 'DESC') // Trie les résultats par email de façon décroissante
        ->getQuery() // Génère la requête
        ->getResult(); // Exécute la requête et retourne les résultats
}





}
