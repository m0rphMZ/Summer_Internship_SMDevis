<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use App\Repository\ReponsesRepository;
use App\Repository\ReclamationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Form\FormError;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mime\Email as MimeEmail;





class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
public function index(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator, \Symfony\Component\Mailer\MailerInterface $mailer): Response
{
    $users = new Users();

    $form = $this->createFormBuilder($users)
        ->add('nom', TextType::class, [
            'label' => 'nom:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre nom',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Votre nom doit comporter au moins {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('prenom', TextType::class, [
            'label' => 'prenom:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre prénom',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Votre prénom doit comporter au moins {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('civilite', ChoiceType::class, [
            'label' => 'Type de réclamation:',
            'placeholder' => 'Sélectionnez',
            'choices' => [
                'M.' => 'Monsieur',
                'Mme.' => 'Madame',
                'Mlle.' => 'Mademoiselle',
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez sélectionner une civilité',
                ]),
            ],
            'invalid_message' => 'Veuillez sélectionner une civilité',
            'attr' => [
                'onchange' => 'removePlaceholderOption()',
            ],
        ])

        
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

        ->add('codepostal', IntegerType::class, [
            'label' => 'codepostal:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre code postal',
                ]),
                new Regex([
                    'pattern' => '/^[0-9]+$/',
                    'message' => 'Veuillez saisir un code postal valide',
                ]),
                new Length([
                    'min' => 5,
                    'minMessage' => 'Votre code postal doit comporter au moins {{ limit }} caractères',
                ]),
            ],
            'invalid_message' => 'Veuillez saisir un code postal valide (8 chiffres uniquement)',
            'attr' => [
                'min' => 10000000,
                'max' => 99999999,
                'oninput' => "this.value = this.value.replace(/[^0-9]/g, '').substring(0, 8);",
            ],
        ])




        ->add('telephone', IntegerType::class, [
            'label' => 'telephone:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre numéro de téléphone',
                ]),
                new Regex([
                    'pattern' => '/^\d{8}$/',
                    'message' => 'Veuillez saisir un numéro de téléphone valide (8 chiffres uniquement)',
                ]),
            ],
            'invalid_message' => 'Veuillez saisir un numéro de téléphone valide (8 chiffres uniquement)',
            'attr' => [
                'min' => 10000000,
                'max' => 99999999,
                'oninput' => "this.value = this.value.replace(/[^0-9]/g, '').substring(0, 8);",
            ],
        ])

        
        ->add('adresse', TextType::class, [
            'label' => 'adresse:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre adresse',
                ]),
                new Length([
                    'min' => 5,
                    'minMessage' => 'Votre adresse doit comporter au moins {{ limit }} caractères',
                ]),
            ],
        ])
        ->add('ville', TextType::class, [
            'label' => 'ville:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre ville',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Votre ville doit comporter au moins {{ limit }} caractères',
                ]),
            ],
        ])
        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $users = $form->getData();
        $users->setEtat('Active');
        $users->setType('User');

        
            // Check if the email already exists in the database
        $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['email' => $users->getEmail()]);

        if ($existingUser) {
            $form->get('email')->addError(new FormError('Cet email est déjà utilisé'));
            return $this->render('home/index.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'HomeController',
            ]);
    }




        $unique = false;
        while (!$unique) {
            $loginCode = mt_rand(10000, 99999);
            
            // Check if the login code already exists in the database
            $existingUser = $entityManager->getRepository(Users::class)->findOneBy(['loginCode' => $loginCode]);
            
            if (!$existingUser) {
                $unique = true;
            }
        }
        
        $users->setLoginCode($loginCode);
        


        $entityManager->persist($users);
        $entityManager->flush();

        // Add success flash message
        $this->addFlash('success', $translator->trans('Votre code de connexion a été envoyé par e-mail.'));

        // Send email to user
        $email = (new MimeEmail())
            ->from('smdevistun@gmail.com')
            ->to($users->getEmail())
            ->subject('SM Devis - Login Code')
            ->html('<p>Bonjour '.$users->getNom().',</p><p>Voici votre code de connexion : '.$users->getLoginCode().'</p><p>Merci de l\'utiliser pour accéder à votre compte.</p>');
        $mailer->send($email);



        return $this->redirectToRoute('app_home');
    }

    return $this->render('home/index.html.twig', [
        'form' => $form->createView(),
        'controller_name' => 'HomeController',
    ]);
}
}