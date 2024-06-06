<?php

namespace Warehouse\Models;

class User
{
    public $id;
    public $accessCode;
    public $username;

    public function __construct($username, $accessCode)
    {
        $this->id = \Warehouse\Utils\UUID::v4();
        $this->username = $username;
        $this->accessCode = $accessCode;
    }
}
