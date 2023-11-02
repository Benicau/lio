<?php

namespace App\Controller;


use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Devis;
use App\Entity\Facture;
use App\Form\DevisType;
use App\Entity\TexteApi;
use App\Form\FactureType;
use App\Repository\DevisRepository;
use App\Repository\ColorsRepository;
use App\Repository\ClientsRepository;
use App\Repository\CategoryRepository;
use App\Repository\TexteApiRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CompanyInfoRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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

    #[Route('/indexhome/transform', name: 'app_api_transform')]
    public function trans(DevisRepository $devisRepository): Response
    {
        $newDevis = $devisRepository->findNewDevisOrderedByDate();

        return $this->render('api/transform.html.twig', [
            'controller_name' => 'ApiController',
            'devis' => $newDevis,
        ]);
    }
    
    #[Route('/indexhome/devis', name: 'app_api_devis', methods: ['GET','POST'])]
    public function devis(EntityManagerInterface $manager, Request $request, CategoryRepository $categoryRepository, ClientsRepository $clientRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $clients = $clientRepository->findBy([], ['id' => 'DESC']);
        $devis = new Devis();
        $form = $this->createForm(DevisType::class, $devis);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($devis);
            $manager->flush();
            $devisId = $devis->getId();

            $this->addFlash(
                'success',
                "Le devis a bien été crée"
            );
            return $this->redirectToRoute('app_api_devis_success', ['id' => $devisId]);
            
        }

        return $this->render('api/devis.html.twig', [
            'controller_name' => 'ApiController',
            'categories' => $categories,
            'clients' => $clients,
            'form'=>$form->createView()  
        ]);
    }


    #[Route('/indexhome/facture', name: 'app_api_facture', methods: ['GET','POST'])]
    public function facture(EntityManagerInterface $manager, Request $request, CategoryRepository $categoryRepository, ClientsRepository $clientRepository): Response
    {
        $categories = $categoryRepository->findAll();
        $clients = $clientRepository->findBy([], ['id' => 'DESC']);
        $facture = new Facture();
        $form = $this->createForm(FactureType::class, $facture);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($facture);
            $manager->flush();
            $factureId = $facture->getId();

            $this->addFlash(
                'success',
                "La facture a bien été crée"
            );
            return $this->redirectToRoute('app_api_facture_success', ['id' => $factureId]);
            
        }

        return $this->render('api/facture.html.twig', [
            'controller_name' => 'ApiController',
            'categories' => $categories,
            'clients' => $clients,
            'form'=>$form->createView()  
        ]);
    }

    #[Route('/indexhome/facture/success/{id}', name: 'app_api_facture_success')]
    public function goodtoo(int $id): Response
    {
        return $this->render('api/successtoo.html.twig', [
            'controller_name' => 'ApiController',
            'facture_id' => $id,
        ]);
    }

    #[Route('/indexhome/devis/success/{id}', name: 'app_api_devis_success')]
    public function good(int $id): Response
    {
        return $this->render('api/success.html.twig', [
            'controller_name' => 'ApiController',
            'devis_id' => $id,
        ]);
    }

    #[Route('/indexhome/devis/pdf/{id}', name: 'app_api_devis_pdf')]
    public function pdf(Devis $devis, CompanyInfoRepository $companyInfoRepository, TexteApiRepository $texteApiRepository, ColorsRepository $colorsRepository ): Response
    {
        $companyInfo = $companyInfoRepository->find(1);
        $couleur = $colorsRepository->find(1);
        $tvatexte = $texteApiRepository->find(2);
        $condition = $texteApiRepository->find(1);
        $brusselsTimeZone = new \DateTimeZone('Europe/Brussels');
        $brusselsDate = $devis->getEndDate()->setTimezone($brusselsTimeZone);
        $data = [
            'id' => $devis->getId(),
            'date' => $brusselsDate->format('d/m/Y'),
            'companyInfo' => $companyInfo,
            'couleur' => $couleur,
            'tvatexte' => $tvatexte,
            'condition' => $condition,
            'texte' => $devis->getTexte(),
            'createdAt' => $devis->getCreatedAt(),
            'montantHorsTva' => $devis->getMontantHorsTva(),
            'tauxTva' => $devis->getTauxTva(),
            'accompte' => $devis->getAccompte(),
            'client' => $devis->getClient(),        
        ];
        $html = $this->renderView('api/devisPdf.html.twig', [
            'data' => $data,
    ]);
    $pdfOptions = new Options();
    $pdfOptions->set('defaultFont', 'Roboto'); 
    $pdfOptions->set('isRemoteEnabled', true); 
    $dompdf = new Dompdf($pdfOptions);
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();
    $canvas = $dompdf->getCanvas();
    $canvas->page_text(520, 800, "Page: {PAGE_NUM} de {PAGE_COUNT}", null, 6, [0, 0, 0]);
    $id = strval($devis->getId());
    return new Response(
        $dompdf->output(),
        Response::HTTP_OK,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="devis'.$id.'.pdf"'
        ]
    );
    }

    #[Route('/indexhome/facture/pdf/{id}', name: 'app_api_facture_pdf')]
    public function pdf2(Facture $facture, CompanyInfoRepository $companyInfoRepository, TexteApiRepository $texteApiRepository, ColorsRepository $colorsRepository): Response
    {
        $companyInfo = $companyInfoRepository->find(1);
        $tvatexte = $texteApiRepository->find(2);
        $condition = $texteApiRepository->find(1);
        $couleur = $colorsRepository->find(1);
        $brusselsTimeZone = new \DateTimeZone('Europe/Brussels');
        $brusselsDate = $facture->getEndDate()->setTimezone($brusselsTimeZone);

        $data = [
            'id' => $facture->getId(),
            'date' => $brusselsDate->format('d/m/Y'),
            'companyInfo' => $companyInfo,
            'couleur' => $couleur,
            'tvatexte' => $tvatexte,
            'condition' => $condition,
            'texte' => $facture->getTexte(),
            'createdAt' => $facture->getCreatedAt(),
            'montantHorsTva' => $facture->getMontantHorsTva(),
            'tauxTva' => $facture->getTauxTva(),
            'benefice' => $facture->getBenefice(),
            'accompte' => $facture->getAccompte(),
            'client' => $facture->getClient(),
        ];
        $html = $this->renderView('api/facturePdf.html.twig', [
            'data' => $data,
        ]);
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Roboto');
        $pdfOptions->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($pdfOptions);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $canvas = $dompdf->getCanvas();
        $canvas->page_text(520, 800, "Page: {PAGE_NUM} de {PAGE_COUNT}", null, 6, [0, 0, 0]);
        $id = strval($facture->getId());
        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="facture'.$id.'.pdf"'
            ]
        );
    }

    #[Route('/devis/refuser/{id}', name: 'app_devis_refuser')]
    public function refuserDevis(int $id, DevisRepository $devisRepository, EntityManagerInterface $entityManager): Response
    {
        $devis = $devisRepository->find($id);
        $devis->setEtat('REFUSER');
        $entityManager->flush();
        $this->addFlash('success', 'Le devis a été refusé avec succès.');

        return $this->redirectToRoute('app_api_transform');
    }

    #[Route('/devis/accept/{id}', name: 'app_devis_accept')]
    public function acceptDevis(int $id, DevisRepository $devisRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $devis = $devisRepository->find($id);
        
        // Mettre à jour l'état du devis
        $devis->setEtat('ACCEPTER');

        // Créer une nouvelle facture
        $facture = new Facture();
        
        // Transférer les valeurs de Devis à Facture
        $facture->setClient($devis->getClient());
        $facture->setTexte($devis->getTexte());
        $facture->setMontantHorsTva($devis->getMontantHorsTva());
        $facture->setTauxTva($devis->getTauxTva());
        $facture->setBenefice($devis->getBenefice());
        
        // Utiliser la nouvelle valeur de l'acompte
        $new_accompte = $request->request->get('new_accompte');
        $facture->setAccompte(floatval($new_accompte));

        $date_end_str = $request->request->get('new_endDate');
        if ($date_end_str) {
            try {
                $date_end = new \DateTime($date_end_str);
                $facture->setEndDate($date_end);
            } catch (\Exception $e) {
                // Gérer l'exception, par exemple ajouter un message flash.
                $this->addFlash('error', "La date d'échéance fournie n'est pas valide.");
            }
        }


        // Sauvegarder les modifications
        $entityManager->persist($facture);
        $entityManager->flush();

        // Récupérer l'ID de la nouvelle facture pour la redirection
        $factureId = $facture->getId();

        $this->addFlash(
            'success',
            "La facture a bien été créée"
        );
        return $this->redirectToRoute('app_api_facture_success', ['id' => $factureId]);
    }





}