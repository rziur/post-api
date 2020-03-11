<?php

namespace App\Tests\Controller;

use Proxies\__CG__\App\Entity\Post;
use Proxies\__CG__\App\Entity\User;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    public function testCreatePostSuccess()
    {
        $client = static::createClient();

        $id = $this->getOneUserId($client);

        $client->request(
            'POST',
            '/api/posts',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(["title" => 'test_title', "body" => 'body test', 'userId' => $id])
        );

        $this->assertEquals(201, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);

        $title = $content['title'];
        $body = $content['body'];

        $this->assertEquals('test_title', $title);
        $this->assertEquals('body test', $body);
    }

    public function testCreatePostInvalidTitle()
    {
        $client = static::createClient();

        $id = $this->getOneUserId($client);

        $client->request(
            'POST',
            '/api/posts',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(["body" => 'body test', 'userId' => $id])
        );

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }

    public function testGetPostsByUserId()
    {
        $client = static::createClient();

        $id = $this->getOneUserId($client);

        $client->request('GET', '/api/posts/user/' . $id);

        $this->assertResponseIsSuccessful();
    }

    public function testGetPostDetailWithAllComments()
    {
        $client = static::createClient();

        $id = $this->getOnePostId($client);

        $client->request('GET', 'posts/' . $id . '/comments');

        $this->assertResponseIsSuccessful();
    }

    
    public function testUpdatePostSuccess()
    {
        $client = static::createClient();

        $id = $this->getOnePostId($client);

        $client->request(
            'PUT',
            '/api/posts/' . $id,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(["title" => 'test_title_upd', "body" => 'body test_UPD', 'userId' => $id])
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $content = json_decode($client->getResponse()->getContent(), true);

        $title = $content['title'];
        $body = $content['body'];

        $this->assertEquals('test_title_upd', $title);
        $this->assertEquals('body test_UPD', $body);
    }

    public function testGetPosts()
    {
        $client = static::createClient();

        $client->request('GET', '/api/posts');

        $this->assertResponseIsSuccessful();
    }

    private function getOnePostId($client)
    {
        $client->request('GET', '/api/posts');

        $content = json_decode($client->getResponse()->getContent(), true);

        return $content[0]['id'];    
    }

    private function getOneUserId($client)
    {
        $client->request('GET', '/api/users');

        $content = json_decode($client->getResponse()->getContent(), true);

        return $content[0]['id'];
    }

}
