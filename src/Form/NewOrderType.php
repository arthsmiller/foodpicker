<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('restaurants', EntityType::class, [
                'class' => Restaurant::class,
                'choice_label' => function ($restaurant) {
                    return $restaurant->getName();
                },
                'expanded' => true,
                'multiple' => false
            ])
            ->add('order_time', TextType::class, [
                'attr' => [
                    'placeholder' => 'YYYY-MM-DD HH:MM', 'class' => 'form-control form-control-rounded'
                ]])
            ->add('delivery_time', TextType::class, [
                'attr' => [
                    'placeholder' => 'YYYY-MM-DD HH:MM', 'class' => 'form-control form-control-rounded'
                ]])
            ->add('total_price',NumberType::class, [
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
            ->add('total_persons',NumberType::class, [
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
            ->add('total_items',NumberType::class, [
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
            ->add('faulty', CheckboxType::class, [
                'required' => false
            ])
            ->add('bonus', CheckboxType::class, [
                'required' => false
            ])
            ->add('driver_needed_help', CheckboxType::class, [
                'required' => false
            ])
            ->add('score', NumberType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'pls max 3 points if food was great'
                ]
            ])
        ;
    }
}