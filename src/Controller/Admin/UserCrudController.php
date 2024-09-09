<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // Définir les champs que tu veux afficher, par exemple :
            TextField::new('email'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            // Ajoute d'autres champs en fonction des besoins
        ];
    }
}
