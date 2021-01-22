<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;

final class BlogTagAdmin extends AbstractAdmin
{
    private $locales;

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    public function getNewInstance()
    {
        $hairColor = parent::getNewInstance();

        foreach ($this->locales as $locale) {
            $hairColor->translate($locale)->setName('New');
        }
        $hairColor->mergeNewTranslations();
        foreach ($this->locales as $locale) {
            $hairColor->translate($locale)->setName('');
        }

        return $hairColor;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('nameDefault')
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
                ]);
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('translations', null, [
                'template' => 'Admin/BlogTag/show_translations.html.twig',
            ]);
    }
}
