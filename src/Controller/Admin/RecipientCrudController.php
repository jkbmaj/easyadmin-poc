<?php

namespace App\Controller\Admin;

use App\Entity\Recipient;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

class RecipientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipient::class;
    }

    #[\Override]
    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('name'),

            Field::new('email')
                ->hideWhenUpdating(),

            Field::new('source'),

            Field::new('browser')
                ->hideOnForm(),

            Field::new('ip')
                ->hideOnForm(),

            Field::new('verifiedAt')
                ->hideOnForm(),

            Field::new('consentAt')
                ->hideOnForm(),

            Field::new('unsubscribedAt')
                ->hideOnForm(),
        ];
    }

    #[\Override]
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Odbiorca')
            ->setEntityLabelInPlural('Odbiorcy')
            ->setDefaultSort([
                'verifiedAt' => 'DESC',
                'consentAt' => 'DESC',
            ]);
    }

    #[\Override]
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('email'))
            ->add(TextFilter::new('source'))
            ->add(TextFilter::new('ip'))
        ;
    }
}
