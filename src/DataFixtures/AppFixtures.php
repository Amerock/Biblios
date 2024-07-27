<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Factory\AuteurFactory;
use App\Factory\EditeurFactory;
use App\Factory\LivreFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        AuteurFactory::createMany(50);
        EditeurFactory::createMany(20);
        UserFactory::createMany(5);
        LivreFactory::createMany(100);
    }
}