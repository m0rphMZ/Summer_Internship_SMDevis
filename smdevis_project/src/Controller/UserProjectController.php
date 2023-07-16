<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Projets;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Regex;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\Form\FormError;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Mime\Email as MimeEmail;



class UserProjectController extends AbstractController
{
    #[Route('/newprojet', name: 'app_user_project')]
    public function index(Request $request, EntityManagerInterface $entityManager, \Symfony\Component\Mailer\MailerInterface $mailer): Response
    {
        $projet = new projets();
    
        $form = $this->createFormBuilder($projet)
            ->add('nom_dem', TextType::class, [
                'label' => 'nom demandeur:',
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
            ->add('prenom_dem', TextType::class, [
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

            ->add('civilite_dem', ChoiceType::class, [
                'label' => 'Type de réclamation:',
                'placeholder' => 'Sélectionner une civilité',
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
                    'onchange' => 'removePlaceholderOption("form_civilite_dem")',
                ],
            ])

            ->add('telephone_dem', IntegerType::class, [
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

            ->add('adresse_dem', TextType::class, [
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

            ->add('ville_dem', TextType::class, [
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

            ->add('codepostale_dem', IntegerType::class, [
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
                    'oninput' => "this.value = this.value.replace(/[^0-5]/g, '').substring(0, 4);",
                ],
            ])

            ->add('email_dem', TextType::class, [
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

            ->add('titreprojet', TextType::class, [
                'label' => 'Titre de projet:',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez écrire le titre de votre projet',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'le titre doit comporter au moins {{ limit }} caractères',
                    ]),
                ],
            ])

            ->add('situation_proj', ChoiceType::class, [
                'label' => 'Votre situation:',
                'placeholder' => 'Sélectionner Votre situation',
                'choices' => [
                    'Propriétaire' => 'proprietaire',
                    'Locataire' => 'locataire',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner Votre situation',
                    ]),
                ],
                'invalid_message' => 'Veuillez sélectionner Votre situation',
                'attr' => [
                    'onchange' => 'removePlaceholderOption("form_situation_proj")',
                ],
            ])

            ->add('type_bien', ChoiceType::class, [
                'label' => 'Type de bien:',
                'placeholder' => 'Sélectionner Votre Type',
                'choices' => [
                    'Appartement' => 'appartement',
                    'Maison' => 'maison',
                    'Studio' => 'studio',
                    'Immeuble' => 'immeuble',
                    'Villa' => 'villa',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner Votre Type',
                    ]),
                ],
                'invalid_message' => 'Veuillez sélectionner Votre Type',
                'attr' => [
                    'onchange' => 'removePlaceholderOption("form_type_bien")',
                ],
            ])

            ->add('budget_proj', NumberType::class, [
                'label' => 'Budget:',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez rédiger un budget.',
                    ]),
                    new GreaterThan([
                        'value' => 100,
                        'message' => 'Le budget doit être supérieur à 100DT.',
                    ]),
                ],
            ])

            ->add('etat_bien', ChoiceType::class, [
                'label' => 'Etat de bien:',
                'placeholder' => 'Sélectionner Votre Etat',
                'choices' => [
                    'Neuf' => 'neuf',
                    'Ancien' => 'ancien',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner Votre Etat',
                    ]),
                ],
                'invalid_message' => 'Veuillez sélectionner Votre Etat',
                'attr' => [
                    'onchange' => 'removePlaceholderOption("form_etat_bien")',
                ],
            ])

            ->add('delai_realisation', ChoiceType::class, [
                'label' => 'Délai de réalisation de vos travaux:',
                'placeholder' => 'Sélectionner Votre délai de réalisation de vos travaux',
                'choices' => [
                    'Pas de date fixe' => 'no_date',
                    'immédiatement' => 'immediat',
                    'Dans 1 mois' => '1mois',
                    'Entre 3 et 6 mois' => '3-6mois',
                    '+12 mois' => '+12mois',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner Votre délai de réalisation de vos travaux',
                    ]),
                ],
                'invalid_message' => 'Veuillez sélectionner Votre délai de réalisation de vos travaux',
                'attr' => [
                    'onchange' => 'removePlaceholderOption("form_delai_realisation")',
                ],
            ])

            ->add('periode_rappel', ChoiceType::class, [
                'label' => 'Période de rappel:',
                'placeholder' => 'Sélectionner Votre période de rappel',
                'choices' => [
                    'Matin' => 'matin',
                    'Après midi' => 'apres_midi',
                    'Soir' => 'soir',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner Votre période de rappel',
                    ]),
                ],
                'invalid_message' => 'Veuillez sélectionner Votre période de rappel',
                'attr' => [
                    'onchange' => 'removePlaceholderOption("form_periode_rappel")',
                ],
            ])

            ->add('objet_dem_proj', TextType::class, [
                'label' => 'Objet de la demande:',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez écrire l\'objet de la demande:',
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'l\'objet de la demande doit comporter au moins {{ limit }} caractères',
                    ]),
                ],
            ])

            ->add('description_proj', TextareaType::class, [
                'label' => 'Description:',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez écrire la description de votre projet',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'la description doit comporter au moins {{ limit }} caractères',
                    ]),
                ],
            ])


            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $projet = $form->getData();
            $projet->setDateDemProj(new \DateTime());
    

    
            $entityManager->persist($projet);
            $entityManager->flush();
    
            // Add success flash message
    
            $this->addFlash('success', 'Votre projet a été ajouté à la base de données, vous recevrez un appel d\'un des prestataires si votre demande correspond à leurs offres.');
    
    
            // Send email to partner
                $email = (new MimeEmail())
                ->from('smdevistun@gmail.com')
                ->to($projet->getEmailDem())
                ->subject('SM Devis - Code de connexion')
                ->html('<p>Bonjour '.$projet->getNomDem().',</p><p>Votre projet a été ajouté à la base de données, vous recevrez un appel d\'un des prestataires si votre demande correspond à leurs offres'.'</p><p>Cordialement,</p><p>L\'équipe SM Devis</p>');
                $mailer->send($email);
    
    
    
    
            return $this->redirectToRoute('app_user_project');
        }
    
        return $this->render('userproject/userproject.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'UserProjectController',
        ]);
    }
}
