<?php

namespace App\Form;

use App\Entity\ClassFGW;
use App\Entity\Student;
use App\Entity\Subject;
use App\Entity\SubjectSchedule;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubjectScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Starting Date',
                'widget' => 'single_text',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('slot', IntegerType::class, [
                'label' => 'Total Slots',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('student', EntityType::class, [
                'label' => 'Select student for this schedule',
                'class' => Student::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('subject', EntityType::class, [
                'label' => 'Select subject for this schedule',
                'class' => Subject::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('class', EntityType::class, [
                'label' => 'Select the class for this schedule',
                'class' => ClassFGW::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('teacher', EntityType::class, [
                'label' => 'Select the teacher for this schedule',
                'class' => Teacher::class,
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
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SubjectSchedule::class,
        ]);
    }
}
