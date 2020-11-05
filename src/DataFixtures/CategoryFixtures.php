<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i=0;$i<10;$i++) {
            $cat = new Category();
            $cat->setTitle("Catégorie ".$i);
            $manager->persist($cat);
        }

        $manager->flush();
    }
}
