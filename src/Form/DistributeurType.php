<?php

namespace App\Form;

use App\Entity\Distributeur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Formulaire DistributeurType
 *
 * Ce formulaire est utilisé pour créer et mettre à jour des distributeurs.
 * Il inclut un champ pour le nom du distributeur.
 */
class DistributeurType extends AbstractType
{
    /**
     * Construit le formulaire.
     *
     * @param FormBuilderInterface $builder Le constructeur de formulaire
     * @param array $options Les options du formulaire
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom', TextType::class, [
            'label' => 'Nom du distributeur',
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
            'data_class' => Distributeur::class,
        ]);
    }
}
