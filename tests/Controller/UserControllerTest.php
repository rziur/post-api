<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Ramsey\Uuid\Uuid;

class UserControllerTest extends WebTestCase
{

    public function testGetUsers()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/users');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserGeneratingId()
    {
        $client = static::createClient();

        $id = Uuid::uuid4();

        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(["id" => $id ,"name" => 'test_user_1', "email" => 'test_1@gmail.com'])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
   }

    public function testCreateUser()
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/users',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(["name" => 'test_user', "email" => 'test@gmail.com'])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $content = json_decode($client->getResponse()->getContent(), true);
        $name = $content['name'];
        $email = $content['email'];
        $this->assertEquals('test_user', $name);
        $this->assertEquals('test@gmail.com', $email);
   }

   public function testCreateUserEmailExist()
   {
       $client = static::createClient();

       $client->request(
           'POST',
           '/api/users',
           [],
           [],
           ['CONTENT_TYPE' => 'application/json'],
           json_encode(["name" => 'test', "email" => 'user_1@gmail.com'])
       );

       $this->assertEquals(400, $client->getResponse()->getStatusCode());
      
  }
}
