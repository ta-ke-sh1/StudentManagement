<?php

namespace App\Form;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Teacher Name',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])

            ->add('dob', DateType::class,[
                'label' => 'Date of Birth',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ] 
            ])
            ->add('phone', TextType::class,[
                'label' => 'Phone number',
                'required' => false,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('address', TextType::class,[
                'label' => 'Address',
                'required' => false,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('email', TextType::class,[
                'label' => 'Email',
                'required' => false,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
