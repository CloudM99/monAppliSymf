<?php

namespace App\Controller;

use App\Entity\Distributeur;
use App\Entity\Produit;
use App\Form\ProduitType;
use App\Form\DistributeurType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Contrôleur AdminController
 *
 * Gère les opérations CRUD pour les produits et les distributeurs.
 * Accessible uniquement aux utilisateurs ayant le rôle ROLE_ADMIN.
 */
#[Route("/admin")]
#[IsGranted('ROLE_ADMIN')]
class AdminController extends AbstractController
{
    /**
     * Insère un nouveau produit dans la base de données.
     *
     * @param Request $request La requête HTTP
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */
    #[Route('/insert', name: 'insert')]
    public function insert(Request $request, EntityManagerInterface $entityManager)
    {
       $produit = new Produit;
       $formProduit=$this->createForm(ProduitType::class, $produit);
       $formProduit->add('creer', SubmitType::class, array('label' => 'Insertion d\'un produit', 'validation_groups'=>array('registration', 'all')));
        $formProduit->handleRequest($request);
            if($request->isMethod('POST') && $formProduit->isValid()){

                $file =$formProduit['lienImage']->getData();

                if(!is_string($file)){

                    $filename = $file->getClientOriginalName();
                    $file->move(
                        $this->getParameter('images_directory'),
                        $filename
                    );
                    $produit->setLienImage($filename);
                } else {
                    $session = $request->getSession();
                    $session->getFlashbag()->add('message', 'Vous devez choisir une image pour le produit');
                    $session->set("statut","danger");

                    return $this->redirect($this->generateUrl('insert'));
                }
                $entityManager->persist($produit);
                $entityManager->flush();

                $session=$request->getSession();
                $session->getFlashbag()->add('message', 'Un nouveau produit a été ajouté ');
                $session->set('statut', "success");
                return $this->redirect($this->generateUrl('liste'));
            }

        return $this->render('admin/create.html.twig', array('my_form'=>$formProduit->createView()));
    }


    /**
     * Met à jour un produit existant dans la base de données.
     *
     * @param Request $request La requête HTTP
     * @param int $id L'identifiant du produit à mettre à jour
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */
    #[Route('/update/{id}', name: 'update')]
    public function update(Request $request, $id,EntityManagerInterface $entityManager)
    {
        $produitRepository=$entityManager->getRepository(Produit::class);
        $produit=$produitRepository->find($id);

        $currentImage=$produit->getLienImage();
        $formProduit=$this->createForm(ProduitType::class,$produit);

        $formProduit->add('creer', SubmitType::class, array(
            'label'=>'Mise à jour',
            'validation_groups'=>array('all')
        ));
        $formProduit->handleRequest($request);

        if($request->isMethod('post')&&$formProduit->isValid()) {
            $file=$formProduit['lienImage']->getData();
                if($file !== null && !is_string($file)){
                    $filename=$file->getClientOriginalName();
                    $file->move(
                        $this->getParameter('images_directory'),
                        $filename
                    );
                    $produit->setLienImage($filename);
                } else {
                    $produit->setLienImage($currentImage);
                }

                $entityManager->persist($produit);
                $entityManager->flush();
                $session=$request->getSession();
                $session->getFlashBag()->add('message','Le produit a été mis à jour');
                $session->set('statut','succes');
                return $this->redirect($this->generateUrl('liste'));

        }

        return $this->render('admin/create.html.twig',
        array("my_form"=>$formProduit->createView()));
    }

    /**
     * Supprime un produit de la base de données.
     *
     * @param Request $request La requête HTTP
     * @param int $id L'identifiant du produit à supprimer
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */
    #[Route("/delete/{id}", name:"delete")]
    function delete(Request $request, $id,EntityManagerInterface $entityManager)
    {
        $produitRepository=$entityManager->getRepository(Produit::class);
        $produit=$produitRepository->find($id);
        $entityManager->remove($produit);
        $entityManager->flush();
        $session=$request->getSession();
        $session->getFlashBag()->add('message','le produit a été supprimé');
        $session->set('statut','success');
        return $this->redirect($this->generateUrl('liste'));
    }

    /**
     * Gère les opérations CRUD pour les distributeurs.
     *
     * @param Request $request La requête HTTP
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */

    #[Route('/gestion_distributeur', name: 'gestion_distributeur')]
    public function gestion_distributeur(Request $request, EntityManagerInterface $entityManager)
    {
        $distributeurRepository = $entityManager->getRepository(Distributeur::class);
        $distributeurs = $distributeurRepository->findAll();

        $distributeur = new Distributeur();
        $formDistributeur = $this->createForm(DistributeurType::class, $distributeur);

        // Ajouter le bouton de soumission
        $formDistributeur->add('creer', SubmitType::class, [
            'label' => 'Ajout d\'un nouveau distributeur'
        ]);

        // Gérer la soumission du formulaire
        $formDistributeur->handleRequest($request);

        if ($request->isMethod('POST') && $formDistributeur->isSubmitted() && $formDistributeur->isValid()) {
            $entityManager->persist($distributeur);
            $entityManager->flush();

            // Ajouter un message flash pour le succès
            $this->addFlash('success', 'Un nouveau distributeur a été ajouté.');

            // Redirection vers la même page pour rafraîchir la liste
            return $this->redirectToRoute('gestion_distributeur');
        }

        // Si le formulaire n'est pas soumis ou invalide, afficher le formulaire
        return $this->render('admin/gestion_distributeur.html.twig', [
            'form' => $formDistributeur->createView(),
            'distributeurs' => $distributeurs,
        ]);
    }
    #[Route('/delete_distributeur/{id}', name: 'delete_distributeur')]
    public function delete_distributeur(Request $request, $id, EntityManagerInterface $entityManager): Response
    {
        $distributeurRepository = $entityManager->getRepository(Distributeur::class);
        $distributeur = $distributeurRepository->find($id);

        if (!$distributeur) {
            throw $this->createNotFoundException('Le distributeur avec l\'ID ' . $id . ' n\'existe pas.');
        }

        // Vérifier si le distributeur est utilisé par un produit
        $query = $entityManager->createQuery(
            'SELECT COUNT(p) FROM App\Entity\Produit p JOIN p.distributeurs d WHERE d.id= :distributeurId'
        )->setParameter('distributeurId', $id);
        $count = $query->getSingleScalarResult();
        if($count > 0){
            $this->addFlash('error', 'Impossible de supprimer le distributeur car il est relié à un produit.');
            return $this->redirectToRoute('gestion_distributeur');
        }

        $entityManager->remove($distributeur);
        $entityManager->flush();

        $this->addFlash('success', 'Le distributeur a été supprimé.');

        return $this->redirectToRoute('gestion_distributeur');
    }



}
