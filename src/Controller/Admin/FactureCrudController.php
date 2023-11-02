<?php

namespace App\Controller\Admin;

use App\Entity\Facture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FactureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Facture::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $pdfAction = Action::new('pdf', 'PDF')
        ->linkToRoute('app_api_facture_pdf', function (Facture $facture) {
            return ['id' => $facture->getId()];
        })
        ->setHtmlAttributes(['target' => '_blank']);
        return $actions
        ->add(Crud::PAGE_INDEX, $pdfAction)
        ->disable(Action::NEW, Action::EDIT);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Numéro de facture')->hideOnForm(),
            DateTimeField::new('createdAt', 'Création'),
            NumberField::new('montantHorsTva', 'Montant Hors TVA'),
            NumberField::new('TauxTva', 'Taux TVA'),
            NumberField::new('benefice', 'Bénéfice'),
            NumberField::new('accompte', 'Acompte'),
            DateTimeField::new('endDate', 'Date d\'échéance'),
            AssociationField::new('client'),
        ];
    }
    
}
