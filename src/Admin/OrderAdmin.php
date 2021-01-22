<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Order;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\DoctrineORMAdminBundle\Filter\ChoiceFilter;
use Sonata\DoctrineORMAdminBundle\Filter\StringListFilter;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class OrderAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->clearExcept(['list', 'show']);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('createdAt')
            ->add('status',
                ChoiceFilter::class, [],
                ChoiceType::class, [
                    'choices' => [
                        'New' => Order::STATUS_NEW,
                        'In progress' => Order::STATUS_IN_PROGRESS,
                        'Complete' => Order::STATUS_COMPLETE,
                        'Canceled' => Order::STATUS_CANCELED,
                    ],
                    'multiple' => true,
                ]);
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('createdAt')
            ->add('customer')
            ->add('status', 'string', [
                'template' => 'Admin/Order/status_list.html.twig',
            ])
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                ],
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('status', 'string', [
                'template' => 'Admin/Order/status_show.html.twig',
            ])
            ->add('isShipmentSameAsBilling', 'string', [
                'template' => 'Admin/Order/address_show.html.twig',
            ])
            ->add('deliveryMethod')
            ->add('id')
            ->add('createdAt')
            ->add('customer')
            ->add('amount')
            ->add('entries', null, [
                'template' => 'Admin/Order/entries_show.html.twig'
            ]);
    }
}
