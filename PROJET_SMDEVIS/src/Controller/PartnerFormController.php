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







class PartnerFormController extends AbstractController
{
    #[Route('/form', name: 'app_form')]
public function index(Request $request, EntityManagerInterface $entityManager, \Symfony\Component\Mailer\MailerInterface $mailer): Response
{
    $partners = new partners();

    $choices = [
        'Alarme (installateur)',
        'Carreleur',
        'Charpentier',
        'Chauffagiste',
        'Climatisation (installateur)',
        'Constructeur de maison',
        'Courtier',
        'Couvreur',
        'Cuisiniste',
        'Décorateur',
        'Dératiseur',
        'Diagnostiqueur Immobilier',
        'Domotique',
        'Electricien',
        'Entreprise générale de bâtiment',
        'Escaliéteur',
        'Fenêtres (installateur)',
        'Forgeron / Ferronnier',
        'Géomètre',
        'Isolation',
        'Jardinier',
        'Maçon',
        'Maître d\'oeuvre',
        'Menuisier',
        'Miroitier / Vitrier',
        'Moquettiste',
        'Parquet (poseur)',
        'Paysagiste',
        'Peintre',
        'Piscines (installateur)',
        'Plaquiste',
        'Plâtrier',
        'Plombier',
        'Portes,fenêtres (installateur de)',
        'Ravaleur de façade',
        'Salle de bains (installateur)',
        'Serrurier',
        'Store (installateur)',
        'Terrassier',
        'Vérandas (installateur)',
    ];
    

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

        
        
        ->add('act_entreprise', ChoiceType::class, [
            'label' => 'Activité de l\'entreprise:',
            'choices' => array_combine($choices, $choices),
            'placeholder' => 'Choisir une activité',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez sélectionner l\'activité principale de votre entreprise',
                ]),
            ],
        ])

        ->add('mat_fisc', TextType::class, [
            'label' => 'Matricule fiscale :',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire la Matricule fiscale de votre entreprise',
                ]),
                new Length([
                    'min' => 2,
                    'minMessage' => 'la Matricule fiscale de votre entreprise doit être plus long que {{ limit }} caractères',
                ]),
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
                        'min' => 4,
                        'minMessage' => 'Votre code postal doit comporter au moins {{ limit }} caractères',
                    ]),
                ],
                'invalid_message' => 'Veuillez saisir un code postal valide (4 chiffres uniquement)',
                'attr' => [
                    'min' => 1000,
                    'max' => 9999,
                    'oninput' => "this.value = this.value.replace(/[^0-9]/g, '').substring(0, 4);",
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

        

        ->add('tel_fix', IntegerType::class, [
            'label' => 'tel_fix:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre numéro de téléphone Fix',
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

        ->add('tel_gsm', IntegerType::class, [
            'label' => 'tel_gsm:',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez écrire votre numéro de téléphone GSM',
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


        ->add('subscription', ChoiceType::class, [
            'label' => 'subscription:',
            'choices' => [
                '1 Mois' => '1',
                '3 Mois' => '3',
                '6 Mois' => '6',
                '12 Mois' => '12',
            ],
            'placeholder' => 'Veuillez choisir une option de souscription',
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez choisir une option de souscription',
                ]),
            ],
            'attr' => [
                'onchange' => 'removePlaceholderOption(this);', // Call the JavaScript function when the select changes
            ],
        ])
        

        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $partners = $form->getData();
        $partners->setEtat('Inactive');
        $partners->setRole('User');
        $partners->setDatePartSub(new \DateTime());

        
            // Check if the email already exists in the database
        $existingPartner = $entityManager->getRepository(Partners::class)->findOneBy(['email' => $partners->getEmail()]);

        if ($existingPartner) {
            $form->get('email')->addError(new FormError('Cet email est déjà utilisé'));
            return $this->render('partnerform/partnerform.html.twig', [
                'form' => $form->createView(),
                'controller_name' => 'PartnerFormController',
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
            ->html('<p>Bonjour '.$partners->getNom().',</p><p>Votre partenariat avec SM Devis a été enregistré et sera examiné par un administrateur. Vous recevrez votre code de connexion une fois qu\'il sera approuvé.</p><p>Merci de votre patience et de votre intérêt pour SM Devis.</p><p>Cordialement,</p><p>L\'équipe SM Devis</p>');
            $mailer->send($email);




        return $this->redirectToRoute('app_form');
    }

    return $this->render('partnerform/partnerform.html.twig', [
        'form' => $form->createView(),
        'controller_name' => 'PartnerFormController',
    ]);
}

}