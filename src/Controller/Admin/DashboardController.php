<?php

namespace App\Controller\Admin;

use App\Entity\Devis;
use App\Entity\Facture;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Clients;
use App\Entity\CompanyInfo;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(ProductCrudController::class)
        ->generateUrl();

        return $this->redirect($url);

       
    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration');
    }

    public function configureMenuItems(): iterable
    {
        
        yield MenuItem::section('Produits');
        yield MenuItem::subMenu('Actions', 'fa fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un produit','fas fa-plus', Product::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les produits', 'fas fa-eye', Product::class)
        ]);
        
        yield MenuItem::subMenu('Catégories', 'fa fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter une catégorie','fas fa-plus', Category::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories', 'fas fa-eye', Category::class)
        ]);
        yield MenuItem::section('Clients');
        yield MenuItem::subMenu('Clients', 'fa fa-bars')->setSubItems([
            MenuItem::linkToCrud('Ajouter un client','fas fa-plus', Clients::class )->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les clients', 'fas fa-eye', Clients::class)
        ]);
        yield MenuItem::section('Devis');
        yield MenuItem::subMenu('Actions', 'fa fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir les devis', 'fas fa-eye', Devis::class)
        ]);
        yield MenuItem::section('Facture');
        yield MenuItem::subMenu('Actions', 'fa fa-bars')->setSubItems([
            MenuItem::linkToCrud('Voir les factures', 'fas fa-eye', Facture::class)
        ]);
        yield MenuItem::section('Configuration');
        $editUrl = $this->adminUrlGenerator
            ->setAction('edit')
            ->setController(CompanyInfoCrudController::class)
            ->setEntityId(1)  
            ->generateUrl();

            $editUrl2 = $this->adminUrlGenerator
            ->setAction('edit')
            ->setController(TexteApiCrudController::class)
            ->setEntityId(1) 
            ->generateUrl();

            $editUrl3 = $this->adminUrlGenerator
            ->setAction('edit')
            ->setController(TexteApiCrudController::class)
            ->setEntityId(2) 
            ->generateUrl();

            $editUrl4 = $this->adminUrlGenerator
            ->setAction('edit')
            ->setController(ColorsCrudController::class)
            ->setEntityId(1) 
            ->generateUrl();

        yield MenuItem::linktoUrl('Infos Entreprise', 'fas fa-cogs', $editUrl);
        yield MenuItem::linktoUrl('Conditions de Vente', 'fas fa-file-contract', $editUrl2);
        yield MenuItem::linktoUrl('Texte TVA 6%', 'fas fa-file', $editUrl3);
        yield MenuItem::linktoUrl('Couleur du PDF', 'fas fa-palette', $editUrl4);
        yield MenuItem::section('Lien'); // Ajoutez une nouvelle section au menu
        $apiUrl = $this->generateUrl('app_api'); // Remplacez 'app_api' par le nom de votre route
        yield MenuItem::linkToUrl('Lien vers API', 'fa fa-link', $apiUrl); // Ajoutez le lien vers votre route


    }
}
