<?php

namespace App\Controller\Admin;

use App\Entity\Newsletter;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\HttpFoundation\Response;

class NewsletterCrudController extends AbstractCrudController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public static function getEntityFqcn(): string
    {
        return Newsletter::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            Field::new('title'),
            Field::new('content'),
            Field::new('isSent')->hideOnForm(),
            Field::new('createdAt')->hideOnForm(),
            Field::new('updatedAt')->hideOnForm(),
            AssociationField::new('template')->renderAsNativeWidget(),
            AssociationField::new('createdBy')->renderAsNativeWidget()->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $sendNewsletter = Action::new('sendNewsletter', 'Wyślij do subskrybentów', 'fas fa-envelope')
            ->linkToCrudAction('sendNewsletter');

        $sendNewsletterToYourself = Action::new('sendNewsletterToYourself', 'Wyślij tylko do siebie', 'fas fa-envelope')
            ->linkToCrudAction('sendNewsletterToYourself');

        $isSent = static fn (Newsletter $entity): bool => false === $entity->isIsSent();
        $canEditCallback = static fn (Action $action): Action => $action->displayIf($isSent);

        return $actions
            ->add(Crud::PAGE_DETAIL, $sendNewsletter)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_DETAIL, $sendNewsletterToYourself)
            ->update(Crud::PAGE_INDEX, Action::EDIT, $canEditCallback)
            ->update(Crud::PAGE_DETAIL, Action::EDIT, $canEditCallback);
    }

    public function sendNewsletter(AdminContext $adminContext): Response
    {
        $newsletter = $adminContext->getEntity()->getInstance();

        $newsletter->setIsSent(true);

        $this->entityManager->persist($newsletter);
        $this->entityManager->flush();

        // for now, just return an empty response
        return new Response('');
    }

    public function sendNewsletterToYourself(): Response
    {
        // for now, just return an empty response
        return new Response('OKS');
    }
}
