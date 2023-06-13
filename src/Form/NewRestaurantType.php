<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class NewRestaurantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class, ['attr' => ['class' => 'form-control form-control-rounded']])
            ->add('shop_url',TextType::class, ['attr' => ['class' => 'form-control form-control-rounded']])
            ->add('categories', TextType::class, ['attr' => ['class' => 'form-control form-control-rounded']])
            ->add('logo_url', FileType::class, ['attr' => ['class' => 'form-control form-control-rounded', 'type' => 'file']])
            ->add('background_url', FileType::class, ['attr' => ['class' => 'form-control form-control-rounded', 'type' => 'file']])
            // @ToDO categories serialize in output / unserialize in input
            ;
    }
}