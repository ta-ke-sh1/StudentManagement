<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\User;
use App\Form\StudentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'required' => true,
                'attr' => [
                    'id' => 'saveBtn',
                    'class' => 'inp'
                ]
            ])
            ->add('roles', ChoiceType::class, [
                'required' => true,
                'choices'  => [
                    'Student' => 'ROLE_STUDENT',
                    'Teacher' => 'ROLE_TEACHER',
                    'Admin' => 'ROLE_ADMIN',
                ],
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('avatar', FileType::class, [
                'label' => 'Upload the student\'s image',
                'data_class' => null,
                'required' => is_null($builder->getData()->getAvatar()), // getImage(): entity function
                // if Image == null => required = true; else false
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'id' => 'saveBtn',
                    'class' => 'inp editConfirm'
                ],
            ])
            ->add('student', EntityType::class, [
                'label' => 'Select the student\'s to link with',
                'data_class' => null,
                'class' => Student::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'inp'
                ]
            ])
            ->add('Save', SubmitType::class, [
                'attr' => [
                    'class' => 'inp',
                    'id' => 'submit'
                ]
            ]);;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
