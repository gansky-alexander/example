<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class CategoryAdmin extends AbstractAdmin
{
    private $locales;

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    public function prePersist($object)
    {
        $object->uploadImage($this->getRequest()->get('uniqid'));
    }

    public function preUpdate($object)
    {
        $object->uploadImage($this->getRequest()->get('uniqid'));
    }

    public function getNewInstance()
    {
        $category = parent::getNewInstance();

        foreach ($this->locales as $locale) {
            $category->translate($locale)->setName('New');
        }
        $category->mergeNewTranslations();
        foreach ($this->locales as $locale) {
            $category->translate($locale)->setName('');
        }

        return $category;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('image', 'string', [
                'template' => 'Admin/Category/list_image.html.twig',
            ])
            ->add('nameDefault', null, [
                'label' => 'Name',
            ])
            ->add('parent')
            ->add('color', 'string', [
                'template' => 'Admin/Category/list_color.html.twig',
            ])
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
            ->add('color', ColorType::class, [
                'required' => false,
            ])
            ->add('parent')
            ->add('imageFile', FileType::class, [
                'mapped' => true,
                'required' => false,
                'label' => 'Image',
            ])
            ->add('translations', CollectionType::class,
                [
                    'btn_add' => false,
                    'type_options' => [
                        'delete' => false,
                    ],
                    'label' => 'Translations',
                ],
                [
                    'edit' => 'inline',
                    'inline' => 'table',
                ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper->add('id');
    }
}
