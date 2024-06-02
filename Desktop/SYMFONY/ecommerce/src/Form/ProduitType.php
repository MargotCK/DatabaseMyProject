<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextareaType::class, [

                'help' => 'Le titre du produit doit être compris entre 5 et 20 caractères'
                ,

                'help_attr' => [
                    'class' => 'text-info fst-italic'
                ], 

                'label_attr' => [
                    'class' => 'text-success'
                ],

                'row_attr' => [
                    'class' => 'shadow p-3 bg-white'
                ],

                'required'=> false,
                'constraints' => [
                    new NotBlank([
                        'message'=>'Veuillez saisir le titre du produit'
                    ]),
                    new Length([
                        'min'=> 5,
                        'max'=> 20,
                        'minMessage' => 'veuillez saisir au moins 5 caratères',
                        'maxMessage'=> 'veuillez saisir moins de 20 caractères'
                    ])

                ]
                
                //'attr' => []
            ])

            
            ->add('prix', MoneyType::class, [
                //k => v 
                'label' => 'Prix du produit',
                'attr' => [
                    'placeholder' => 'Saisir le prix du produit',
                    'class' =>'inputCyan 
                    border border-danger'
                ],
                'required'=> false,
                
                'constraints' => [
                    new NotBlank([
                        'message'=> 'Veuillez saisir le titre du produit'
                    ]),
                    
                    new Positive([
                        'message' => 'Veuillez saisir un prix supérieur à zéro'
                    ])
                ]
            ])
            

            ->add('description', null, [
                'label' => 'Description (Faclutative)',
                'constraints' => [
                    new Length([
                        'max' => 200,
                        'maxMessage'=> 'veuillez saisir moins de 200 caractères'
                    ])
                ]   
            ])
            //add('ajouter', SubmitType::class) 

            ->add('categorie', EntityType::class, [
                'class' => Categorie::class, // Nom de la class en relation (à importer)
                'choice_label' => 'nom',     // Nom de la propriété à afficher dans le formulaire

                
                'placeholder' => 'Saisir une catégorie',
                'required' => false, 
                // Pour la relation ManyToMany il faut rajouter l'option :
                //'multiple' =>true
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir la catégorie du produit'
                    ]),
                ]

            ])
            
            
            ;
/*
            L'objet $builder permet de construire le formulaire
            Chaque méthode add() va correspondre à un élément du formulaire

            3 arguments dans la méthode add()

            1- (string) nom de la propriété dans l'entity (si le formulaire est lié à une entity)

            2- (nom de la Class): le type de l'élément

            3- (array) : tableau des options
                    2 "genres" d'options :
                        - options communes à toutes les class (2e argument)
                        - options propres à une class





            -----------------------
            en html, il y a 3 types de balises pour le formulaire :
                - select
                - textarea
                - input type : text, password, files, hidden, date, color, number, checkbox radio ....

        */
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}




