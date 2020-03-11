<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testGetComments()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/comments');

        $this->assertResponseIsSuccessful();
    }

}
