<?php

namespace App\Controller\Admin;

use App\Entity\Loan;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

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
            // DateTimeField::new('startDate', 'Loan date')
            // ->setFormat('d/m/Y H:i')
            // DateTimeField::new('expectedReturnDate', 'Expected return date'),
            // DateTimeField::new('returnDate', 'Return date')
            //     ->setFormTypeOption('required', false),
        ];
    }
    
}
