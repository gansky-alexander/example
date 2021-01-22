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

final class BadgeAdmin extends AbstractAdmin
{
    private $locales;

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    public function getNewInstance()
    {
        $badge = parent::getNewInstance();

        foreach ($this->locales as $locale) {
            $badge->translate($locale)->setName('New');
        }
        $badge->mergeNewTranslations();
        foreach ($this->locales as $locale) {
            $badge->translate($locale)->setName('');
        }

        return $badge;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('color');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('nameDefault', null, [
                'label' => 'Name',
            ])
            ->add('color', 'string', [
                'template' => 'Admin/Badge/list_color.html.twig',
            ])
            ->add('usedForSort')
            ->add('sortOrder')
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
            ->add('color', ColorType::class)
            ->add('usedForSort')
            ->add('sortOrder')
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
                ]);;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('color');
    }
}
