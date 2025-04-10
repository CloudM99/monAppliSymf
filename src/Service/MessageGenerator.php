<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class MessageGenerator
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger; // Initialisez la propriété logger
    }

    public function getHappyMessage()
    {
        $messages = [
            'Bravo vous êtes le meilleur !',
            'Ceci est le meilleur service que j\'ai vu ',
            'Beau travail ! Continuez ! ',
        ];

        $index = array_rand($messages);
        $this->logger->info($messages[$index]); // Utilisez le logger
        return $messages[$index];
    }
}