<?php

namespace App\Form;

use App\Entity\ClassFGW;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('subjects', TextType::class,[
                'label' => 'Class Subject',
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClassFGW::class,
        ]);
    }
}
