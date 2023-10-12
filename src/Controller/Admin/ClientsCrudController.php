<?php

// src/Controller/Admin/ClientsCrudController.php

namespace App\Controller\Admin;

use App\Entity\Clients;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ClientsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Clients::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Client')
            ->setEntityLabelInPlural('Clients');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('surname', 'Prénom'),
            TextField::new('compagny', 'Société'),
            TextField::new('adress', 'Adresse'),
            TextField::new('numero', 'Numéro'),
            TextField::new('codePostal', 'Code Postal'),
            TextField::new('city', 'Ville'),
            TextField::new('pays', 'Pays')
            ->setFormTypeOption('data', 'Belgique'),
            TextField::new('tva', 'TVA')
        ];
    }
}
