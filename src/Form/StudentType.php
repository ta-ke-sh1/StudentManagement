<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Student;
use App\Entity\ClassFGW;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

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
            ->add('classFGW', EntityType::class, [
                'label' => 'Select the student\'s class',
                'class' => ClassFGW::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Upload the student\'s image',
                'data_class' => null,
                'required' => is_null($builder->getData()->getImage()), // getImage(): entity function
                // if Image == null => required = true; else false
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('Save', SubmitType::class, [
                'attr' => [
                    'class' => 'inp',
                    'id' => 'saveBtn'
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
