<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class ProductVariantAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('sku');
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('sku')
            ->add('price')
            ->add('oldPrice')
            ->add('stockAmount')
            ->add('color')
            ->add('size')
            ->add('sizeType')
            ;
    }

}
