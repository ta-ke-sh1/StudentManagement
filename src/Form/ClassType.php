<?php

namespace App\Form;

use App\Entity\ClassFGW;
use App\Entity\Subject;
use App\Entity\SubjectSchedule;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ClassType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label' => 'Class Name',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])

            ->add('studentNo', IntegerType::class,[
                'label' => 'Number of Student',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('Year',IntegerType::class,[
                'label' => 'Year',
                'required' => true,
                'attr' => [
                    'class' => ' inp'
                ]
            ])
            ->add('semester',TextType::class,[
                'label' => 'Semester',
                'required'=> true,
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassFGW::class,
        ]);
    }
}
