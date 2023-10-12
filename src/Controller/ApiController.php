<?php

namespace App\Controller;

use App\Repository\ClientsRepository;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use App\Repository\CompanyInfoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class ApiController extends AbstractController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
        
    }
    #[Route('/indexhome', name: 'app_api')]
    public function index(CompanyInfoRepository $companyInfoRepository): Response
    {
        $companyInfo = $companyInfoRepository->findAll();  // ou find pour une seule entité

        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
            'companyInfo' => $companyInfo,
        ]);
    }
    
    #[Route('/indexhome/devis', name: 'app_api_devis')]
    public function devis(ProductRepository $productRepository, CategoryRepository $categoryRepository, ClientsRepository $clientRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $clients = $clientRepository->findBy([], ['id' => 'DESC']);

        return $this->render('api/devis.html.twig', [
            'controller_name' => 'ApiController',
            'categories' => $categories,
            'clients' => $clients,
        ]);
    }









    
        #[Route('/indexhome/facture', name: 'app_api_facture')]
        public function facture(): Response
        {
            return $this->render('api/facture.html.twig', [
                'controller_name' => 'ApiController',
            ]);
        }
    
}
