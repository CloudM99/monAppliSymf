<?php

namespace App\Form;

use App\Entity\Reference;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

/**
 * Formulaire ReferenceType
 *
 * Ce formulaire est utilisé pour créer et mettre à jour des références de produits.
 * Il inclut un champ pour le numéro de référence.
 */
class ReferenceType extends AbstractType
{
    /**
     * Construit le formulaire.
     *
     * @param FormBuilderInterface $builder Le constructeur de formulaire
     * @param array $options Les options du formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('numero', NumberType::class, [
            'label' => 'N° de référence',
            'required' => true,
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
            'data_class' => Reference::class,
        ]);
    }
}
