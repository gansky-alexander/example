<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Templating\TemplateRegistry;
use Sonata\Form\Type\CollectionType;
use Sonata\Form\Type\DatePickerType;

final class BoxAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show', 'edit']);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('date')
            ->add('isFinished');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('customer')
            ->add('date', TemplateRegistry::TYPE_DATE, [
                'format' => 'Y M',
            ])
            ->add('isFinished')
            ->add('items')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    // @formatter:off
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->tab('General')
            ->with('')
                ->add('customer', null, [
                    'disabled' => true,
                ])
                ->add('date', null, [
                    'widget' => 'single_text',
                ])
            ->add('isFinished')
            ->end()
            ->end()

            ->tab('Items')
                ->with('')
                    ->add('items', CollectionType::class,
                        [
                            'by_reference' => false,
                            'btn_add' => true,
                            'type_options' => [
                                'delete' => true,
                            ],
                            'label' => 'Product variant',
                            'error_bubbling' => true,
                        ],
                        [
                            'edit' => 'inline',
                            'inline' => 'table',
                        ])
                ->end()
            ->end();
    }
    // @formatter:on

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('customer')
            ->add('date', TemplateRegistry::TYPE_DATE, [
                'format' => 'Y M',
            ])
            ->add('items')
            ->add('isFinished');
    }
}
