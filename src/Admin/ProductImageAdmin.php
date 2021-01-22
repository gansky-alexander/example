<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Show\ShowMapper;

final class ProductImageAdmin extends AbstractAdmin
{

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('mediaImage', ModelListType::class, array(
                'required' => false
            ), array(
                'link_parameters' => array(
                    'context' => 'default',
                    'provider' => 'sonata.media.provider.image'
                )
            ))
            ->add('isMain')
        ;
    }

}
