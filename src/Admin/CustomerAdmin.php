<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Customer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

final class CustomerAdmin extends AbstractAdmin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('email')
            ->add('name')
            ->add('gender')
            ->add('dateOfBirth')
            ->add('subscriptionEnd')
            ->add('isEnabled')
            ->add('allowNotifications')
            ->add('allowOrderNotifications')
            ->add('allowsPromotionNotifications')
            ->add('allowActivityNotifications')
            ->add('allowEmailNotifications');
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('email')
            ->add('name')
            ->add('gender')
            ->add('dateOfBirth')
            ->add('subscriptionEnd')
            ->add('isEnabled')
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
            ->add('email')
            ->add('name')
            ->add('gender', ChoiceType::class, [
                'required' => false,
                'choices' => [
                    'Hidden' => Customer::SEX_HIDDEN,
                    'Male' => Customer::SEX_MALE,
                    'Female' => Customer::SEX_FEMALE,
                ],
            ])
            ->add('dateOfBirth', null, [
                'widget' => 'single_text',
            ])
            ->add('subscriptionEnd', null, [
                'widget' => 'single_text',
            ])
            ->add('isEnabled');
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('avatar', 'string', [
                'label' => 'Avatar',
                'template' => 'Admin/Customer/show_avatar.html.twig',
            ])
            ->add('id')
            ->add('email')
            ->add('name')
            ->add('gender')
            ->add('dateOfBirth')
            ->add('subscriptionEnd')
            ->add('token')
            ->add('isEnabled')
            ->add('allowNotifications')
            ->add('allowOrderNotifications')
            ->add('allowsPromotionNotifications')
            ->add('allowActivityNotifications')
            ->add('allowEmailNotifications');
    }
}
