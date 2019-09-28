<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogTest extends WebTestCase {

    public function testCreateArticle(){
        $data = [
            'title' => 'asd',
            'text' => 'asd',
            'author' => 'asd'
        ];

        $client = self::createClient();
        $client->request('POST', '/articles', $data);

        $statusCode = $client->getResponse()->getStatusCode();
        $body = $client->getResponse()->getContent();
        $body = json_decode($body);
        
        
        $this->assertEquals(200, $statusCode);
        $this->assertStringMatchesFormat('%i', $body->id);
        $this->assertEquals($data['title'], $body->title);
        $this->assertEquals($data['text'], $body->text);
        $this->assertEquals($data['author'], $body->author);
    }

}