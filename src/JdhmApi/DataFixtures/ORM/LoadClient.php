<?php

namespace JdhmApi\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use JdhmApi\Entity\Client;

class LoadClient implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<20; $i++) {
            $client = new Client();
            $client = $this->generateNames(new Client());
            $client = $this->generateEmail($client);
            $client->setDateOfBirth(new \DateTime("now"));

            $manager->persist($client);

        }
        $manager->flush();
    }

    private function generateNames(Client $client)
    {
        $firstNames = [
            'Paul',
            'Dave',
            'Mark',
            'Jerome',
            'Eleonor',
            'Pauline',
            'Daniel',
            'Vincent',
        ];

        $lastNames = [
            'Gauthier',
            'Smith',
            'Dupont',
            'Martin',
            'Richard',
            'Lefevre',
            'Lambert',
            'Sanchez',
            'Perrin',
            'Chevalier',
        ];

        $firstName = $firstNames[array_rand($firstNames, 1)];
        $lastName = $lastNames[array_rand($lastNames, 1)];

        $client->setFirstName($firstName);
        $client->setLastName($lastName);

        return $client;
    }

    private function generateEmail(Client $client)
    {
        $domains = [
            'foo',
            'bar',
            'youla',
            'boolus',
            'lovesy',
            'kool',
            'ool',
            'yahcafe',
            'hillo'
        ];

        $tdls = [
            '.com',
            '.biz',
            '.org',
            '.ca',
            '.fr',
            '.de'
        ];

        $firstName = $client->getFirstName();
        $lastName = $client->getLastName();

        $part1 = strtolower($firstName.'.'.$lastName);

        $domain = $domains[array_rand($domains, 1)];
        $tdl = $tdls[array_rand($tdls, 1)];

        $email = $part1.'@'.$domain.$tdl;

        $client->setEmail($email);

        return $client;
    }
}
