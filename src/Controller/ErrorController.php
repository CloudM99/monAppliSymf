<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ErrorHandler\Exception\FlattenException;

/**
 * Contrôleur ErrorController
 *
 * Gère l'affichage des pages d'erreur.
 */
class ErrorController extends AbstractController
{
    /**
     * Affiche une page d'erreur avec le message de l'exception.
     *
     * @param FlattenException $exception L'exception capturée
     * @return Response La réponse HTTP
     */
    #[Route('/error', name: 'error')]
    public function show(FlattenException $exception)
    {
        $message=$exception->getMessage();

        return $this->render('Exception/index.html.twig',
            ['message'=>$message]);
    }
}