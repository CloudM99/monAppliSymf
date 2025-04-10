<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Contrôleur RegisterController
 *
 * Gère l'inscription des utilisateurs.
 */
class RegisterController extends AbstractController
{
    /**
     * Affiche le formulaire d'inscription et traite la soumission.
     *
     * @param Request $request La requête HTTP
     * @param UserPasswordHasherInterface $passwordHasher Le service de hachage de mot de passe
     * @param EntityManagerInterface $entityManager Le gestionnaire d'entités Doctrine
     * @return Response La réponse HTTP
     */

    #[Route('/register', name:'register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher,EntityManagerInterface $entityManager)
    {
        $form=$this->createFormBuilder()
            ->add('username')
            ->add('password', RepeatedType::class, [
                'type'=>PasswordType::class,
                'required'=>true,
                'first_options'=>['label'=>'Mot de passe'],
                'second_options'=>['label'=>'Confirmation 
Mot de passe'],
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',

                ],
                'multiple'=>true
            ])
            ->add('register', SubmitType::class, [
                'attr'=>[
                    'class'=>'btn btn-success',
                ]
            ])
            ->getForm();

        $form->handleRequest($request);
        if($request->isMethod('post') && $form->isValid() ){

            $data=$form->getData();
            $user=new User;
            $user->setUsername($data['username']);
            $user->setPassword(

                $passwordHasher->hashPassword(
                    $user,
                    $data['password']
                )
            );
            $user->setRoles($data['roles']);

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirect($this->generateUrl
            ('app_login'));

        }
        return $this->render('register/index.html.twig',
            ['my_form'=>$form->createView()]);
    }
}