<?php

namespace App\DataFixtures;

use App\Entity\Charity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\DataFixtures\CategoryFixtures;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CharityFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
 
        $charity1 = new Charity();
        $charity1->setCategory($this->getReference(CategoryFixtures::CATEGORY_ONE));   
        $charity1->setName('Dogs Trust');  
        $charity1->setAddress('17 Wakley Street, London, EC1V 7RQ');  
        $charity1->setDescription('Dogs Trust, formerly known as the National Canine Defence League, is an animal welfare charity and humane society in the United Kingdom which specialises in the well-being of dogs. The charity rehabilitates and finds new homes for dogs which have been abandoned or given up by their owners.');  
        $manager->persist($charity1);
        
        $charity2 = new Charity();
        $charity2->setCategory($this->getReference(CategoryFixtures::CATEGORY_TWO));   
        $charity2->setName('The Greenpeace Environmental Trust');  
        $charity2->setAddress('Canonbury Villas, London N1 2PN, UK');  
        $charity2->setDescription('The Greenpeace Environmental Trust is a registered charity (284934) and a company limited by guarantee (company number 1636817). Founded in 1982 with the objective of “furthering public understanding of and promoting the protection of world ecology and the natural environment”.');  
        $manager->persist($charity2);

        $charity3 = new Charity();
        $charity3->setCategory($this->getReference(CategoryFixtures::CATEGORY_THREE));   
        $charity3->setName('Penumbra');  
        $charity3->setAddress('Norton Park, 57 Albion Road, Edinburgh, EH7 5QY');  
        $charity3->setDescription('Penumbra is one of Scotland’s largest mental health charities. They support around 1600 adults and young people every week and employ 400 staff across Scotland.
        Founded in 1985, they work to promote mental health and wellbeing for all, prevent mental ill health for people who are ‘at risk’, and to support people with mental health problems.');  
        $manager->persist($charity3);

        $charity4 = new Charity();
        $charity4->setCategory($this->getReference(CategoryFixtures::CATEGORY_ONE));   
        $charity4->setName('WWF Scotland');  
        $charity4->setAddress('The Tun, 4 Jackson’s Entry, Holyrood Road, Edinburgh, EH8 8PJ');  
        $charity4->setDescription('The World Wide Fund for Nature is an international non-governmental organization founded in 1961, working in the field of the wilderness preservation, and the reduction of human impact on the environment.');  
        $manager->persist($charity4);

        $charity5 = new Charity();
        $charity5->setCategory($this->getReference(CategoryFixtures::CATEGORY_FIVE));   
        $charity5->setName('Save the Children International');  
        $charity5->setAddress('Prospect House, 2nd Floor, 5 Thistle Street, Edinburgh. EH2 1DF');  
        $charity5->setDescription("The Save the Children Fund, commonly known as Save the Children, is an international non-governmental organisation that promotes children's rights, provides relief and helps support children in developing countries.");  
        $manager->persist($charity5);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
        );
    }
}
