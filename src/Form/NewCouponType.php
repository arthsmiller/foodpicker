<?php

namespace App\Form;

use App\Entity\Restaurant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewCouponType extends AbstractType
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
                'multiple' => false,
                'required' => false,
            ])
            ->add('receive_time', TextType::class, [
                'attr' => [
                    'placeholder' => 'YYYY-MM-DD HH:MM', 'class' => 'form-control form-control-rounded'
            ]])
            ->add('expiration_time', TextType::class, [
                'attr' => [
                    'placeholder' => 'YYYY-MM-DD HH:MM', 'class' => 'form-control form-control-rounded'
            ]])
            ->add('amount', TextType::class, [
                'attr' => [
                    'class' => 'form-control form-control-rounded'
                ]])
        ;
    }
}