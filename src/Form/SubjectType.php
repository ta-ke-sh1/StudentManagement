<?php

namespace App\Form;

use App\Entity\Subject;
use App\Entity\ClassFGW;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Subject Name',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('description', TextType::class, [
                'label' => 'Subject Description',
                'required' => true,
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('totalSlots', IntegerType::class, [
                'label' => 'Total Slots',
                'required' => true,
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
            'data_class' => Subject::class,
        ]);
    }
}
