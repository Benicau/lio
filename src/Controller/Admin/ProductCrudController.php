<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Produit')
            ->setEntityLabelInPlural('Produits');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('description')->setLabel('Titre du produit'),
            NumberField::new('price')->setLabel('Prix de vente Hors/tva'),  // Ici, j'ai retiré setFormType et setFormTypeOptions
            NumberField::new('achat')->setLabel("Prix d'achat Hors/tva"),  // Ici aussi
            DateTimeField::new('createdAt')->hideOnForm()->setLabel('Date de création'),
            AssociationField::new('category')->setLabel("Catégorie du produit"),
            IdField::new('id')->hideOnForm()
        ];
    }
}

