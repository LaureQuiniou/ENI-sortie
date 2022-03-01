<?php

namespace App\Form;


use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut', DateTimeType::class,['html5'=>true, 'widget'=>'single_text'])
            ->add('dateLimiteInscription',DateType::class,['html5'=>true, 'widget'=>'single_text'])
            ->add('duree', TimeType::class, ['html5'=>true, 'widget'=>'single_text'])
            ->add('nbInscriptionsMax',IntegerType::class, ['attr' => ['min'=>'2','value'=>'2'], 'label'=>'Nombre Maximum de participants'])
            ->add('infosSortie', TextareaType::class,['label'=>'Description de la sortie'])
            ->add('lieu',LieuType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
