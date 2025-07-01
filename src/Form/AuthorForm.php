<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
    ->add('username') // Ajoute un champ de type texte lié à la propriété 'username' de l'entité
    ->add('email') // Ajoute un champ de type texte lié à la propriété 'email'
    ->add('Ajouter', SubmitType::class) // Ajoute un bouton de soumission avec le label "Ajouter"
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
