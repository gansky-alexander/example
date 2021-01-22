<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

final class SkinToneTranslationAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->clearExcept(array('edit', 'new'));
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('locale', null, [
                'disabled' => true,
                'label' => 'Locale',
            ])
            ->add('name', null, [
                'label' => 'Hair color name',
            ])

        ;
    }
}
