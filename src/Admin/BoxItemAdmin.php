<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\BoxItem;
use App\Entity\ProductVariant;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class BoxItemAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('edit');
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('variant', null, [
                'class' => ProductVariant::class,
                'label' => 'Variant',
                'required' => true,
                'query_builder' => function ($query) {
                    $qb = $query->createQueryBuilder('pv')
                        ->innerJoin('pv.product', 'p')
                        ->where('p.usedForBox = :usedForBox AND p.isActive = :isActive')
                        ->setParameters([
                            'usedForBox' => true,
                            'isActive' => true,
                        ]);

                    return $qb;
                }
            ])
            ->add('createdBy', null, [
                'empty_data' => BoxItem::CREATED_BY_SYSTEM,
                'attr' => ['readonly' => true],
                'label' => false,
            ]);
    }

}
