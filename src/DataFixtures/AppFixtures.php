<?php

namespace App\DataFixtures;

use App\Entity\Operation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

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

        $manager->flush();
    }
}
