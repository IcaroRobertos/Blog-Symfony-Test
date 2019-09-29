<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Faker;

class BlogTest extends WebTestCase {

    public function testCreateArticle(){

        $faker = Faker\Factory::create();

        $data = [
            'title' => $faker->catchPhrase,
            'text' => $faker->realText,
            'author' => $faker->firstName
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

    public function testGetArticleList(){
        $client = self::createClient();
        $client->request('GET', '/articles');

        $statusCode = $client->getResponse()->getStatusCode();
        $body = $client->getResponse()->getContent();
        $body = json_decode($body);

        $firstArticle = $body[0];

        $this->assertEquals(200, $statusCode);
        $this->assertObjectHasAttribute('id', $firstArticle);
        $this->assertObjectHasAttribute('title', $firstArticle);
        $this->assertObjectHasAttribute('text', $firstArticle);
        $this->assertObjectHasAttribute('author', $firstArticle);
    }

}