<?php

namespace App\Controller\Admin;

use App\Entity\Devis;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DevisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Devis::class;
    }

    public function configureActions(Actions $actions): Actions
{
    $pdfAction = Action::new('pdf', 'PDF')
        ->linkToRoute('app_api_devis_pdf', function (Devis $devis) {
            return ['id' => $devis->getId()];
        })
        ->setHtmlAttributes(['target' => '_blank']);

    return $actions
        ->add(Crud::PAGE_INDEX, $pdfAction)
        ->disable(Action::NEW, Action::EDIT);
}

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Numéro du devis')->hideOnForm(),
            DateTimeField::new('createdAt', 'Création'),
            TextField::new('etat', 'Statut'),
            NumberField::new('montantHorsTva', 'Montant Hors TVA'),
            NumberField::new('TauxTva', 'Taux TVA'),
            NumberField::new('benefice', 'Bénéfice'),
            NumberField::new('accompte', 'Acompte'),
            DateTimeField::new('endDate', 'Date d\'échéance'),
            AssociationField::new('client'),
        ];
    }
}

