<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('restaurant', EntityType::class, [
                'class' => Restaurant::class,
                'choice_label' => function ($restaurant) {
                    return $restaurant->getName();
                },
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('order_time', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
            ->add('delivery_time', DateTimeType::class, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
            ->add('total_price', NumberType::class, [
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
            ->add('total_items', NumberType::class, [
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
            ]);
    }
}