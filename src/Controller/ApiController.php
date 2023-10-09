<?php

namespace App\Controller;

use App\Repository\CompanyInfoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
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
    public function devis(): Response
    {
        return $this->render('api/devis.html.twig', [
            'controller_name' => 'ApiController',
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
