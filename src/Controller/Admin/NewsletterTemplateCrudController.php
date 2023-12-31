<?php

namespace App\Controller\Admin;

use App\Entity\NewsletterTemplate;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class NewsletterTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return NewsletterTemplate::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('title')
                ->hideWhenUpdating(),

            TextField::new('content')
                ->hideWhenUpdating()
                ->hideOnIndex()
                ->renderAsHtml(),

            Field::new('isActive'),

            Field::new('createdAt')
                ->hideOnForm(),

            Field::new('updatedAt')
                ->hideOnForm(),

            AssociationField::new('createdBy')
                ->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $sendTemplate = Action::new('sendTemplate', 'Send', 'fas fa-envelope')
            ->linkToCrudAction('sendTemplate');

        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_DETAIL, $sendTemplate);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Szablon wiadmości')
            ->setEntityLabelInPlural('Szablony wiadmości')
            ->setDefaultSort([
                'isActive' => 'DESC',
                'updatedAt' => 'DESC',
                'createdAt' => 'DESC',
            ]);
    }

    public function sendTemplate(): Response
    {
        // for now, just return an empty response
        return new Response('OK');
    }
}
