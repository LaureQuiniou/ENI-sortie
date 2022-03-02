<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use phpDocumentor\Reflection\PseudoType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'required' => false
            ])
            ->add('prenom', TextType::class, [
                'required' => false
            ])
            ->add('nom', TextType::class, [
                'required' => false
            ])
            ->add('telephone', TextType::class, [
                'required' => false
            ])
            ->add('email', TextType::class, [
                'required' => false
            ])
            ->add('newPassword', RepeatedType::class, [
                'mapped'=>false,
                'required' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots des passes doivent êtes identiques.',
                'first_options'  => ['label' => 'Entrez votre nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmation nouveau mot de passe']
            ])
            ->add('campus', EntityType::class,[
                'label'=> 'campus',
                'class'=> Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('photoFile', VichImageType::class,[
                'label' => 'photo de profil',
                'mapped'=> false, //A revoir? Par défault c'est true
                //'multiple' => false, Quand SELECT ou CHECkBOX
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
