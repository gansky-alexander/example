<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

final class BlogAdmin extends AbstractAdmin
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
            ->add('title')
            ->add('text')
            ->add('isForYou')
            ->add('isPopular')
            ->add('isPublished')
            ->add('publishDate');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('title')
            ->add('image', 'string', [
                'template' => 'Admin/Blog/list_image.html.twig',
            ])
            ->add('tags')
            ->add('isForYou')
            ->add('isPopular')
            ->add('isPublished')
            ->add('publishDate')
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
            ->add('title')
            ->add('text', FormatterType::class, [
                'label' => 'New text',
                'event_dispatcher' => $formMapper->getFormBuilder()->getEventDispatcher(),
                'format_field' => 'contentFormatter',
                'format_field_options' => [
                    'choices' => [
                        'richhtml' => 'Markdown',
                    ],
                    'data' => 'richhtml',
                ],
                'source_field' => 'rawContent',
                'source_field_options' => [
                    'horizontal_input_wrapper_class' => 'col-lg-12',
                    'attr' => ['class' => 'span10 col-sm-10 col-md-10', 'rows' => 20],
                ],
                'listener' => true,
                'target_field' => 'text',
                'ckeditor_context' => 'default',
            ])
            ->add('imageFile', FileType::class, [
                'mapped' => true,
                'required' => false,
                'label' => 'Image',
            ])
            ->add('tags')
            ->add('isForYou')
            ->add('isPopular')
            ->add('isPublished')
            ->add('publishDate', null, [
                'widget' => 'single_text',
            ]);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('title')
            ->add('text', null, [
                'template' => 'Admin/Blog/show_text.html.twig',
            ])
            ->add('image', null, [
                'template' => 'Admin/Blog/show_image.html.twig',
            ])
            ->add('tags')
            ->add('isForYou')
            ->add('isPopular')
            ->add('isPublished')
            ->add('publishDate');
    }
}
