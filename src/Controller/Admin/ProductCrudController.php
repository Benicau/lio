<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
        $fields = [
            TextField::new('description')->setLabel('Titre du produit'),
            NumberField::new('price')
                ->setFormType(MoneyType::class)
                ->setFormTypeOptions([
                    'currency' => 'EUR',
                ])
                ->setLabel('Prix de vente Hors/tva'),
            NumberField::new('achat')
                ->setFormType(MoneyType::class)
                ->setFormTypeOptions([
                    'currency' => 'EUR',
                ])
                ->setLabel("Prix d'achat Hors/tva"),
            DateTimeField::new('createdAt')->hideOnForm()->setLabel('Date de création'),
            AssociationField::new('category')->setLabel("Catégorie du produit"),
        ];

        if ($pageName !== Crud::PAGE_INDEX) {
            $fields[] = IdField::new('id')->hideOnForm();
        }

        return $fields;
    }
}
