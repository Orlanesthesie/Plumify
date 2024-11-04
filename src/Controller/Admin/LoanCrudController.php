<?php

namespace App\Controller\Admin;

use App\Entity\Loan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class LoanCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Loan::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('book', 'Book'),
            AssociationField::new('user', 'User'),
            DateField::new('startDate'),
            DateField::new('endDate'),
            DateField::new('returnDate')
                 ->setFormTypeOption('required', false)

        ];
    }
    
}
