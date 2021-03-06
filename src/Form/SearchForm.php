<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //ce formulaire est en get
            ->setMethod('get')
            ->add('campus', EntityType::class, [
                'label' => 'Campus',
                'class' => Campus::class,
                'choice_label' => 'nom',
                'required' => false,
            ])
            ->add('motClef', SearchType::class, [
                'label' => 'Le nom de la sortie contient : ',
                'required' => false,
            ])
            ->add('dateDebut', DateType::class, [
                'label' => 'Entre le',
                'required' => false,
                'html5'=>true,
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                //'format' => 'dd/MM/yyyy'
            ])
            ->add('dateFin', DateType::class, [
                'label' => 'Et le',
                'required' => false,
                'html5'=>true,
                'widget' => 'single_text',
                'attr' => ['class' => 'datepicker'],
                //'format' => 'dd/MM/yyyy'
            ])
            ->add('est_organisateur', CheckboxType::class, [
                'label' => "Sorties dont je suis l'organisateur/trice",
                'required' => false,
            ])
            ->add('est_inscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
            ])
            ->add('pas_inscrit', CheckboxType::class, [
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
            ])
            ->add('sorties_passees', CheckboxType::class, [
                'label' => 'Sorties pass??es',
                'required' => false,
            ])
            ->add('rechercher', SubmitType::class, ['label' => 'Rechercher'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'csrf_protection' => false
        ]);
    }
}