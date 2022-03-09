<?php

namespace App\Form;

use App\Entity\Grade;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\ClassFGW;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class GradeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('letterGrade', ChoiceType::class, [
                'label' => 'Enter letter grade',
                'choices' => [
                    'Refer' => 'R',
                    'Passed' => 'P',
                    'Merit' => 'M',
                    'Distinction' => 'D',
                ],
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('numberGrade', NumberType::class, [
                'label' => 'Enter number grade',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('student', EntityType::class, [
                'label' => 'Select the student',
                'class' => Student::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('classFGW', EntityType::class, [
                'label' => 'Select the class',
                'class' => ClassFGW::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('subject', EntityType::class, [
                'label' => 'Select the subject',
                'class' => Subject::class,
                'choice_label' => 'name',
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
            'data_class' => Grade::class,
        ]);
    }
}
