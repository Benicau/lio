<?php

namespace App\Controller\Admin;

use App\Entity\CompanyInfo;
use Symfony\Component\Form\FormInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CompanyInfoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CompanyInfo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('information de la société')
            ->setEntityLabelInPlural('informations de la société');
    }


    public function createEditForm(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormInterface
    {
        $entity = $context->getEntity()->getInstance();
        
        // Reste du code
        return parent::createEditForm($entityDto, $formOptions, $context);
    }

    public function configureFields(string $pageName): iterable
    {
        $helpImage = '';  // Initialisez la variable ici

        if (method_exists($this, 'getHelpImage')) {  // Assurez-vous que la méthode existe
            $helpImage = $this->getHelpImage();  // Obtenez la valeur depuis une méthode de la classe
        }

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom de l\'entreprise'),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            TextEditorField::new('slogan', 'Slogan'),
            ImageField::new('logo', 'Logo')
                ->setBasePath('uploads/logos/')
                ->setUploadDir('public/uploads/logos/')
                ->setUploadedFileNamePattern('logo.png')
                ->setRequired(false)
                ->setFormTypeOption('help', $helpImage),  // Utilisez la variable ici
            TextField::new('adress', 'Adresse'),
            TextField::new('pays', 'Pays'),
            TextField::new('city', 'Ville'),
            TextField::new('codePostal', 'Code Postal'),
            TextField::new('phone', 'Numéro de téléphone'),
            TextField::new('tvaNumber', 'Numéro de TVA'),
            TextField::new('banque', 'Numéro de compte'),
            TextField::new('email', 'Email'),
        ];
    }
    
    // Vous pourriez définir cette méthode pour obtenir l'image d'aide, si nécessaire
    protected function getHelpImage(): string
    {

        return '<img src="/uploads/logos/logo.png" width="100" height="auto">';
    }
    public function configureActions(Actions $actions): Actions
{
    $actions
        ->disable('delete')
        ->disable('new');
        
    return $actions;
}
}



