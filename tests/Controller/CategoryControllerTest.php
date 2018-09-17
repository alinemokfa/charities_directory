<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testShowCategories()
    {
        $client = static::createClient();

        $client->request('GET', '/categories');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}