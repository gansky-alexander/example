<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class StoreAdmin extends AbstractAdmin
{
    public function prePersist($object)
    {
        $object->uploadImage($this->getRequest()->get('uniqid'));
    }

    public function preUpdate($object)
    {
        $object->uploadImage($this->getRequest()->get('uniqid'));
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('name')
        ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('image', 'string', [
                'template' => 'Admin/Store/list_image.html.twig',
            ])
            ->add('name')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('imageFile', FileType::class, [
                'mapped' => true,
                'required' => false,
                'label' => 'Image',
            ])
            ->add('name')
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('image', null, [
                'template' => 'Admin/Store/show_image.html.twig',
            ])
            ->add('name')
        ;
    }
}
