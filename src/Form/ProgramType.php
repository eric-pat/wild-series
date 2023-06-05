<?php

namespace App\Form;

use App\Entity\Actor;
use App\Entity\Program;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;


class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class)
            ->add('synopsis', TextType::class)
            ->add('year', NumberType::class)
            ->add('category', null, [
                        'choice_label'=> 'name'])
            ->add('actors', EntityType::class, [
                        'class' => Actor::class,
                        'choice_label' => 'name',
                        'multiple' =>true,
                        'expanded' => true,
                        'by_reference' => false,
            ])
            ->add('posterFile', VichFileType::class, [
                        'required'      => false,
                        'allow_delete'  => true, // not mandatory, default is true
                        'download_uri' => false, // not mandatory, default is true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}