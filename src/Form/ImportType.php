<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
       $builder->add('csv',FileType::class, [
           'mapped' => false,
           'required' => true,
           'label' => false,
           'constraints' => [
               new File([
                   'maxSize' => '1024k',
                   'mimeTypes' => [
                       'text/csv'
                   ],
                   'mimeTypesMessage' => 'Please upload a valid csv document',
               ])
           ]
       ]);
    }
}