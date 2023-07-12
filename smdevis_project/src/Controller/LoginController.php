<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Partners;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;



class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
public function login(Request $request, EntityManagerInterface $entityManager): Response
{


    // Create the login form
    $form = $this->createFormBuilder()

        ->add('email', TextType::class, [
        'label' => 'email :',
        'constraints' => [
            new NotBlank([
                'message' => 'Veuillez écrire votre adresse email',
            ]),
            new Email([
                'message' => 'Veuillez saisir une adresse email valide',
            ]),
        ],
    ])

    ->add('loginCode', PasswordType::class, [
        'label' => 'Login Code',
        'required' => true,
        'constraints' => [
            new NotBlank([
                'message' => 'Veuillez saisir votre code de connexion',
            ]),
        ],
    ])

        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $formData = $form->getData();

        // Check if the email and loginCode are correct
        $partner = $entityManager->getRepository(Partners::class)->findOneBy([
            'email' => $formData['email'],
            'loginCode' => $formData['loginCode'],
        ]);

        if ($partner) {
            // Check if the partner's account is active
            if ($partner->getEtat() === 'Inactive') {
                // Account is inactive, show an error message
                $this->addFlash('danger', 'Votre compte doit être activé par un administrateur.');

                // Redirect to the login page
                return $this->redirectToRoute('app_login');
            }elseif ($partner->getEtat() === 'Permanent'){

                $session = $request->getSession();
                $session->set('admin', $partner);
                return $this->redirectToRoute('app_dashboard');

            }


            // Redirect to the desired page after successful login
            $session = $request->getSession();
            $session->set('partner', $partner);
            return $this->redirectToRoute('app_dashboard');


        } else {
            // Login credentials are incorrect, show an error message
            $this->addFlash('danger', 'Identifiants de connexion incorrects.');

            // Redirect to the login page
            return $this->redirectToRoute('app_login');
        }
    }

    return $this->render('login/login.html.twig', [
        'form' => $form->createView(),
    ]);
}




#[Route('/logout', name: 'app_logout')]
public function logout(Request $request): Response
{

    $request->getSession()->remove('partner');
    $request->getSession()->remove('admin');

    return $this->redirectToRoute('app_login');

}






}
