<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class EditRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('restaurant_name',TextType::class,
                ['attr' => ['class' => 'form-control form-control-rounded'], 'required' => false])
            ->add('shop_url',TextType::class,
                ['attr' => ['class' => 'form-control form-control-rounded'], 'required' => false])
            ->add('categories', TextType::class,
                ['attr' => ['class' => 'form-control form-control-rounded'], 'required' => false])
        ;
    }
}