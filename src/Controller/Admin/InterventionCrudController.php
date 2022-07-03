<?php

namespace App\Controller\Admin;

use App\Entity\Intervention;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;


class InterventionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Intervention::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('user'),
            AssociationField::new('customer'),
            DateField::new('date')->setFormat('dd/MM/yyyyy')->setTimezone('Europe/Paris'),
            DateField::new('startAt')->setFormat('HH:mm')->setTimezone('Europe/Paris'),
            'duration',
            DateField::new('createdAt'),
            'donePaid',
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->disable(Action::NEW, Action::DELETE)
            ->disable(Action::EDIT, Action::EDIT);
    }
    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
