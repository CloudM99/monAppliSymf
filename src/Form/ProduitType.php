<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Distributeur;
use App\Form\Type\MyCheckboxType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Formulaire ProduitType
 *
 * Ce formulaire est utilisé pour créer et mettre à jour des produits.
 * Il inclut des champs pour le nom, le prix, la quantité, l'état de rupture de stock,
 * l'image, la référence, et les distributeurs associés.
 */
class ProduitType extends AbstractType
{
    /**
     * Construit le formulaire.
     *
     * @param FormBuilderInterface $builder Le constructeur de formulaire
     * @param array $options Les options du formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom produit :',
                'required' => true,
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix :',
                'required' => true,
            ])
            ->add('quantite', NumberType::class, [
                'label' => 'Quantité :',
                'required' => true,
            ])
            ->add('rupture', MyCheckboxType::class, [
                'label' => 'Rupture de stock ?',
                'required' => false,
            ])
            ->add('lienImage', FileType::class, [
                'label' => 'Image :',
                'required' => false,
                'data_class' => null,
                'empty_data' => 'aucune image',
            ])
            ->add('reference', ReferenceType::class, [
                'label' => 'Référence du produit',
                'required' => false,
            ])
            ->add('distributeurs', EntityType::class, [
                'class' => Distributeur::class,
                'choice_label' => 'nom',
                'label' => 'Sélection des distributeurs',
                'multiple' => true,
                'required' => false,
            ]);
    }

    /**
     * Configure les options du formulaire.
     *
     * @param OptionsResolver $resolver Le résolveur d'options
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
