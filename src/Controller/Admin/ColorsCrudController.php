<?php

namespace App\Controller\Admin;

use App\Entity\Colors;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ColorsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Colors::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('couleur')
            ->setEntityLabelInPlural('couleurs');
    }

    public function configureActions(Actions $actions): Actions
    {
        $actions
            ->disable('delete')
            ->disable('new');
            
        return $actions;
    }


 
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            ColorField::new('color', 'Couleur'),
        ];
    }

}
