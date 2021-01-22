<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class ProductTranslationAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('locale', null, [
                'disabled' => true,
                'label' => 'Locale',
            ])
            ->add('name', null, [
                'required' => true,
            ])
            ->add('shortDescription', TextareaType::class)
            ->add('description', FormatterType::class, [
                'label' => 'Description',
                'required' => true,
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'descriptionContentFormatter',
                'format_field_options' => [
                    'choices' => [
                        'richhtml' => 'Markdown',
                    ],
                    'data' => 'richhtml',
                ],
                'source_field' => 'descriptionRaw',
                'source_field_options' => [
                    'horizontal_input_wrapper_class' => 'col-lg-12',
                    'attr' => ['class' => 'span10 col-sm-10 col-md-10', 'rows' => 20],
                ],
                'listener' => true,
                'target_field' => 'description',
                'ckeditor_context' => 'default',
            ])
            ->add('ingredients', FormatterType::class, [
                'label' => 'Ingredients',
                'required' => true,
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'ingredientsContentFormatter',
                'format_field_options' => [
                    'choices' => [
                        'richhtml' => 'Markdown',
                    ],
                    'data' => 'richhtml',
                ],
                'source_field' => 'ingredientsRaw',
                'source_field_options' => [
                    'horizontal_input_wrapper_class' => 'col-lg-12',
                    'attr' => ['class' => 'span10 col-sm-10 col-md-10', 'rows' => 20],
                ],
                'listener' => true,
                'target_field' => 'ingredients',
                'ckeditor_context' => 'default',
            ])

        ;
    }

}
