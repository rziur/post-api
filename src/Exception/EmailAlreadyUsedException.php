<?php

namespace App\Exception;

class EmailAlreadyUsedException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Email already used.');
    }
}
