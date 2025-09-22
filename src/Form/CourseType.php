<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Course;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('startTime')
            ->add('endTime')
            ->add('dayOfWeek')
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => 'id',
            ])
            ->add('classroom', EntityType::class, [
                'class' => Classroom::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Course::class,
        ]);
    }
}
