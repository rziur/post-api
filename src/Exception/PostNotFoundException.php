<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('Post not found.');
    }
}