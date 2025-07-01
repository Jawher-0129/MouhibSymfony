<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('title') // Champ de texte lié à la propriété 'title' du livre (Book)

    ->add('publicationDate') // Champ de type date (Symfony le détecte automatiquement si votre entité est bien typée)

    ->add('category', ChoiceType::class, [ // Champ de sélection avec des choix prédéfinis
        'choices' => [ // Liste des options proposées dans le menu déroulant
            'Science-Fiction' => 'Science-Fiction', // Affiché : Science-Fiction, valeur envoyée : Science-Fiction
            'Fantasy' => 'Fantasy',
            'Autobiography' => 'Autobiography',
        ]
    ])

    ->add('author', EntityType::class, [ // Champ lié à une autre entité (Author)
        'class' => Author::class, // Précise la classe de l'entité cible
        'choice_label' => 'username', // Affiche le champ "username" de chaque auteur dans la liste déroulante
    ])

    ->add('Ajouter', SubmitType::class) // Bouton de soumission du formulaire avec le label "Ajouter"
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
