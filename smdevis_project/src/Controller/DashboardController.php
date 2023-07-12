<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Partners;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(): Response
    {
        return $this->render('dashboard/dashboard.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }

    #[Route('/dashboard/partners', name: 'app_dashboard_partners')]
    public function partners(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $entityManager->getRepository(Partners::class);
        
        $partners = $repository->findBy(['role' => 'User']);
        
        $pagination = $paginator->paginate(
            $partners,
            $request->query->getInt('page', 1),
            6 // number of items per page
        );
    
        return $this->render('dashboard/partners.html.twig', [
            'partners' => $pagination,
        ]);
    }

    #[Route('/dashboard/partners/{id}/inactive', name: 'app_dashboard_partners_inactive')]
    public function partnerInactive(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $repository = $entityManager->getRepository(Partners::class);
        
        $partner = $repository->find($id);

        if (!$partner) {
            throw $this->createNotFoundException(
                'Aucun partenaire trouvé pour lidentifiant '.$id
            );
        }

        $partner->setEtat('Inactive');
        $entityManager->flush();
        
    
        return $this->redirectToRoute('app_dashboard_partners');
    }


    #[Route('/dashboard/partners/{id}/active', name: 'app_dashboard_partners_active')]
    public function partnerActive(EntityManagerInterface $entityManager, Request $request, int $id): Response
    {
        $repository = $entityManager->getRepository(Partners::class);
        
        $partner = $repository->find($id);

        if (!$partner) {
            throw $this->createNotFoundException(
                'Aucun partenaire trouvé pour lidentifiant '.$id
            );
        }

        $partner->setEtat('Active');
        $entityManager->flush();
        
    
        return $this->redirectToRoute('app_dashboard_partners');
    }
    
    
}
