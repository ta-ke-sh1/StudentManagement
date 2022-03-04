<?php

namespace App\Form;

use App\Entity\ClassFGW;
use App\Entity\Subject;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('classFGWs', EntityType::class, [
                'label' => 'Select the class for this subject',
                'class' => ClassFGW::class,
                'choice_label' => 'name',
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
