<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
 
        $category1 = new Category();
        $category1->setName('Animal');
        $manager->persist($category1);
        
        $category2 = new Category();
        $category2->setName('Environment');
        $manager->persist($category2);

        $category3 = new Category();
        $category3->setName('Health');
        $manager->persist($category3);

        $category4 = new Category();
        $category4->setName('Education');
        $manager->persist($category4);

        $category5 = new Category();
        $category5->setName('International NGOs');
        $manager->persist($category5);
        
        $manager->flush();
    }
}