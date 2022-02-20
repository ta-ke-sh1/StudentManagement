<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Student Name',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('dob', DateType::class, [
                'label' => 'Date of Birth',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('major', ChoiceType::class, [
                'label' => 'Select a major',
                'choices' => [
                    'Software Engineering' => 'Computing',
                    'Graphic Design' => 'Design',
                    'Business' => 'Business',
                    'Marketing' => 'Marketing'
                ],
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('image', TextType::class, ['attr' => [
                'class' => 'inp'
            ]])
            ->add('Save', SubmitType::class, [
                'attr' => [
                    'class' => 'inp',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
