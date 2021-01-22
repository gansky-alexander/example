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

final class SkinToneAdmin extends AbstractAdmin
{
    private $locales;

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    public function getNewInstance()
    {
        $skinTone = parent::getNewInstance();

        foreach ($this->locales as $locale) {
            $skinTone->translate($locale)->setName('New');
        }
        $skinTone->mergeNewTranslations();
        foreach ($this->locales as $locale) {
            $skinTone->translate($locale)->setName('');
        }

        return $skinTone;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('color', 'string', [
                'template' => 'Admin/SkinTone/list_color.html.twig',
            ])
            ->add('nameDefault', null, [
                'label' => 'Name',
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
            ->add('color', ColorType::class)
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
            ->add('color');
    }
}
