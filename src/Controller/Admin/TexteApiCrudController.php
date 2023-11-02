<?php

namespace App\Controller\Admin;

use App\Entity\TexteApi;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TexteApiCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TexteApi::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('texte')
            ->setEntityLabelInPlural('textes');
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
            TextEditorField::new('texte', 'Texte'),
        ];
    }
}
