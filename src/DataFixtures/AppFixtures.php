<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use App\Entity\Interfaces\UserInterface;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user_1_id = Uuid::uuid4();
        $user_1 = User::create($user_1_id, 'user_1', 'user_1@gmail.com');
        $manager->persist(
            $user_1
        );

        $user_2_id = Uuid::uuid4();
        $user_2 = User::create($user_2_id, 'user_2', 'user_2@gmail.com');
        $manager->persist(
            $user_2
        );

        $user_3_id = Uuid::uuid4();
        $user_3 = User::create($user_3_id, 'user_3', 'user_3@gmail.com'); 
        $manager->persist(
            $user_3
        );

        $post_1_id = Uuid::uuid4();
        $post_1 = Post::create($post_1_id, 'title post test', 'body post test');
        $post_1->setUser($user_1);

        $manager->persist(
            $post_1
        );

        $comment_1_id = Uuid::uuid4();
        $comment_1_user_2_post_1 = Comment::create($comment_1_id, 'comment by user_2 post_1');
        $comment_1_user_2_post_1->setUser($user_2);
        $comment_1_user_2_post_1->setPost($post_1);

        $manager->persist(
            $comment_1_user_2_post_1
        );

        $comment_2_id = Uuid::uuid4();
        $comment_2_user_3_post_1 = Comment::create($comment_2_id, 'comment by user_3 post_1');
        $comment_2_user_3_post_1->setUser($user_3);
        $comment_2_user_3_post_1->setPost($post_1);

        $manager->persist(
            $comment_2_user_3_post_1
        );

        $manager->flush();
    }
}
