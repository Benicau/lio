<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Catégorie')
            ->setEntityLabelInPlural('Catégories');
    }


    
    public function configureFields(string $pageName): iterable
    {
        $fields = [
            // vos autres champs ici
            TextField::new('name')->setLabel('Titre de la catégorie'),
            DateTimeField::new('createdAt')->hideOnForm()->setLabel('Date de création'),
        ];
    
        if ($pageName !== Crud::PAGE_INDEX) {
            $fields[] = IdField::new('id')->hideOnForm();
        }
    
        return $fields;
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if(!$entityInstance instanceof Category) return;
        $entityInstance->setCreatedAt(new \DateTimeImmutable);
        parent::persistEntity($em, $entityInstance);
    }

}
