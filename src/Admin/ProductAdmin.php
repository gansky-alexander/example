<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\ProductVariant;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\AdminType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\CollectionType;

final class ProductAdmin extends AbstractAdmin
{
    private $locales;

    public function setLocales($locales)
    {
        $this->locales = $locales;
    }

    public function getNewInstance()
    {
        $product = parent::getNewInstance();

        foreach ($this->locales as $locale) {
            $product->translate($locale)->setName('New');
            $product->translate($locale)->setShortDescription('New');
            $product->translate($locale)->setDescription('New');
        }
        $product->mergeNewTranslations();
        foreach ($this->locales as $locale) {
            $product->translate($locale)->setName('');
            $product->translate($locale)->setShortDescription('');
            $product->translate($locale)->setDescription('');
        }

        return $product;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('isActive')
            ->add('usedForBox');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('nameDefault')
            ->add('brand')
            ->add('categories')
            ->add('badges')
            ->add('hairColor')
            ->add('rating')
            ->add('amountOfReviews')
            ->add('isActive')
            ->add('usedForBox')
            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    // @formatter:off
    protected function configureFormFields(FormMapper $formMapper): void
    {
        $product = $this->getSubject();

        $formMapper
            ->tab('General')
                ->with('Parameters', ['class' => 'col-md-9'])
                    ->add('brand')
                    ->add('categories')
                    ->add('badges')
                    ->add('hairColor')
                ->end()
                ->with('Price', ['class' => 'col-md-3'])
                    ->add('isActive')
                    ->add('usedForBox')
                ->end()
            ->end();
        if($product->getId()) {
            $formMapper
                ->tab('Images')
                    ->with('')
                        ->add('productImages', CollectionType::class,
                            [
                                'required' => false,
                            ],
                            [
                                'edit' => 'inline',
                                'inline' => 'table',
                            ]
                        )
                    ->end()
                ->end();
        }
        $formMapper
            ->tab('Translations')
                ->with('')
                    ->add('translations', CollectionType::class,
                        [
                            'btn_add' => false,
                            'type_options' => [
                                'delete' => false,
                            ],
                            'label' => '',
                        ],
                        [
                            'edit' => 'inline',
                        ])
                ->end()
            ->end()
            ->tab('Variants')
                ->with('')
                    ->add('productVariants', CollectionType::class,
                        [
                            'by_reference' => false,
                            'btn_add' => true,
                            'type_options' => [
                                'delete' => true,
                            ],
                            'label' => 'Product variant',
                            'error_bubbling' => true,
                        ],
                        [
                            'edit' => 'inline',
                            'inline' => 'table',
                        ])
                ->end()
            ->end()
        ;
    }
    // @formatter:on

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('brand')
            ->add('categories')
            ->add('badges')
            ->add('skinTone')
            ->add('hairColor')
            ->add('price')
            ->add('oldPrice')
            ->add('stockAmount')
            ->add('rating')
            ->add('amountOfReviews')
            ->add('isActive')
            ->add('usedForBox')
            ->add('productImages', null, [
                'template' => 'Admin/Product/images_show.html.twig',
            ])
            ->add('translations', null, [
                'template' => 'Admin/Product/translations_show.html.twig',
            ])
            ->add('variants', null, [
                'template' => 'Admin/Product/variants_show.html.twig',
            ]);
    }
}
