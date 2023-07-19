<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Partners;
use App\Entity\Projets;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email as MimeEmail;
use Doctrine\ORM\QueryBuilder;

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

    

    #[Route('/dashboard/proposals', name: 'app_dashboard_proposals')]
    public function proposals(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $entityManager->getRepository(Projets::class);
        
        // Get the total number of projects
        $totalProjects = $repository->createQueryBuilder('p')
            ->select('COUNT(p.refProj)')
            ->getQuery()
            ->getSingleScalarResult();
        
        // Get the sum of the budget_proj
        $totalBudget = $repository->createQueryBuilder('p')
            ->select('SUM(p.budgetProj)')
            ->getQuery()
            ->getSingleScalarResult();
        
        $proposals = $repository->findAll();
        
        $pagination = $paginator->paginate(
            $proposals,
            $request->query->getInt('page', 1),
            10 // number of items per page
        );
    
        return $this->render('proposals/proposals.html.twig', [
            'proposals' => $pagination,
            'totalProjects' => $totalProjects,
            'totalBudget' => $totalBudget,
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
    public function partnerActive(EntityManagerInterface $entityManager, Request $request, int $id, \Symfony\Component\Mailer\MailerInterface $mailer): Response
    {
        $repository = $entityManager->getRepository(Partners::class);
        
        $partner = $repository->find($id);

        if (!$partner) {
            throw $this->createNotFoundException(
                'Aucun partenaire trouvé pour lidentifiant '.$id
            );
        }

        $partner->setEtat('Active');

        // Send email to partner
        $email = (new MimeEmail())
        ->from('smdevistun@gmail.com')
        ->to($partner->getEmail())
        ->subject('SM Devis - Code de connexion')
        ->html('<p>Bonjour '.$partner->getNom().',</p><p>Votre partenariat avec SM Devis a été accepté. Voici votre code de connexion : '.$partner->getLoginCode().'</p><p>Merci de l\'utiliser pour accéder à votre compte '.$partner->getNomSoc().'.</p><p>Cordialement,</p><p>L\'équipe SM Devis</p>');
        $mailer->send($email);

        $entityManager->flush();
        
    
        return $this->redirectToRoute('app_dashboard_partners');
    }
    
    
}
