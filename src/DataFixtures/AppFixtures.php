<?php

namespace App\DataFixtures;

use App\Entity\Client;
use App\Entity\Commande;
use App\Entity\Operation;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $op1 = new Operation();
        $op1->setNom('Nettoyage Industriel')
            ->setDescription('Nettoyage d’usine, nettoyage de parking')
            ->setPrix(10000)
            ->setTypeOperation('Grosse')
            ->setImage('operations/industriel.png');
        $manager->persist($op1);

        $op2 = new Operation();
        $op2->setNom('Nettoyage Commerces')
            ->setDescription('Nettoyage de commerces, Nettoyage de parking')
            ->setPrix(2500)
            ->setTypeOperation('Moyenne')
            ->setImage('operations/commerce.png');
        $manager->persist($op2);

        $op3 = new Operation();
        $op3->setNom('Nettoyage Particuliers')
            ->setDescription('Nettoyage de maison, nettoyage de jardin')
            ->setPrix(1000)
            ->setTypeOperation('Petite manœuvre')
            ->setImage('operations/maison.png');
        $manager->persist($op3);

        $client1= new Client();
        $client1->setNom('Duong')
        ->setPrenom('Ngo')
        ->setAdresse('Lille')
        ->setEmail('duongngo0103@gmail.com');
        $manager->persist($client1);
        
        $client2= new Client();
        $client2->setNom('Jean')
        ->setPrenom('Pierre')
        ->setAdresse('Paris')
        ->setEmail('dernierPrenix@gmail.com');

        $manager->persist($client2);

        $client3= new Client();
        $client3->setNom('Mohir')
        ->setPrenom('abv')
        ->setAdresse('Lyon')
        ->setEmail('Momo@gmail.com');

        $manager->persist($client3);
        
        $commande1= new Commande();
        $commande1 
        ->setStatut("EnCours")
        ->setFacture("")
        ->setOperation($op1)
        ->setClient($client1);
        $manager->persist($commande1);

        $commande2= new Commande();
        $commande2 
        ->setStatut("Termine")
        ->setFacture("")
        ->setOperation($op2)
        ->setClient($client2);
        $manager->persist($commande2);

        $commande3= new Commande();
        $commande3 
        ->setStatut("Atente")
        ->setFacture("")
        ->setOperation($op3)
        ->setClient($client3);
        $manager->persist($commande3);

       
        $manager->flush();
    }
}
