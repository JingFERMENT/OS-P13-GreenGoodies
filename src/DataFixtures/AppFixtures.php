<?php

namespace App\DataFixtures;

use App\Factory\OrderFactory;
use App\Factory\OrderLineFactory;
use App\Factory\ProductFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(3);
        ProductFactory::createMany(6);
        OrderFactory::createMany(5, function() {
            return [
                'orderLines' => OrderLineFactory::new()->many(3),
            ];
        });
        OrderLineFactory::createMany(10);
        
    }
}
