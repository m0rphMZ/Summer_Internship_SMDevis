<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Partners;
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





class FormController extends AbstractController
{
    #[Route('/form', name: 'app_form')]
public function index(Request $request, EntityManagerInterface $entityManager, TranslatorInterface $translator, \Symfony\Component\Mailer\MailerInterface $mailer): Response
{
    $partners = new partners();

    $form = $this->createFormBuilder($partners)
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

        ->add('nom_soc', TextType::class, [
            'label' => 'Nom de l\'entreprise:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire le nom de votre entreprise',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'Le nom de votre entreprise doit être plus long que {{ limit }} caractères',
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
        $partners = $form->getData();
        $partners->setEtat('Inactive');

        
            // Check if the email already exists in the database
        $existingPartner = $entityManager->getRepository(Partners::class)->findOneBy(['email' => $partners->getEmail()]);

        if ($existingPartner) {
            $form->get('email')->addError(new FormError('Cet email est déjà utilisé'));
            return $this->render('form/form.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'FormController',
            ]);
    }




    $unique = false;
    while (!$unique) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
        $loginCode = '';
        $codeLength = 8;
    
        // Generate a random login code
        for ($i = 0; $i < $codeLength; $i++) {
            $loginCode .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        // Check if the login code already exists in the database
        $existingPartner = $entityManager->getRepository(Partners::class)->findOneBy(['loginCode' => $loginCode]);
    
        if (!$existingPartner) {
            $unique = true;
        }
    }
    
    $partners->setLoginCode($loginCode);
    
        


        $entityManager->persist($partners);
        $entityManager->flush();

        // Add success flash message

        $this->addFlash('success', 'Demande de partenariat enregistrée. Code de connexion envoyé après validation par un administrateur.');


        // Send email to partner
            $email = (new MimeEmail())
            ->from('smdevistun@gmail.com')
            ->to($partners->getEmail())
            ->subject('SM Devis - Code de connexion')
            ->html('<p>Bonjour '.$partners->getNom().',</p><p>Voici votre code de connexion : '.$partners->getLoginCode().'</p><p>Merci de l\'utiliser pour accéder à votre compte '.$partners->getNomSoc().'</p><p>Cordialement,</p><p>L\'équipe SM Devis</p>');
            $mailer->send($email);




        return $this->redirectToRoute('app_home');
    }

    return $this->render('form/form.html.twig', [
        'form' => $form->createView(),
        'controller_name' => 'FormController',
    ]);
}
}