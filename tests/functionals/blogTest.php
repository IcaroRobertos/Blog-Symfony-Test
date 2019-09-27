<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogTest extends WebTestCase {

  public function testCreateArticle(){
    $client = self::createClient();
    $client->request('POST', '/articles');

    $statusCode = $client->getResponse()->getStatusCode();
    
    $this->assertEquals(200, $statusCode);

  }

}