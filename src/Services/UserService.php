<?php

namespace Warehouse\Services;

use Warehouse\Models\User;

class UserService
{
    private $users;

    public function __construct()
    {
        if (file_exists('users.json')) {
            $this->users = json_decode(file_get_contents('users.json'), true);
        } else {
            $this->users = [];
        }
    }

    public function save()
    {
        file_put_contents('users.json', json_encode($this->users, JSON_PRETTY_PRINT));
    }

    public function addUser($username, $accessCode)
    {
        $user = new User($username, $accessCode);
        $this->users[$user->id] = $user;
        $this->save();
    }

    public function authenticate($accessCode)
    {
        foreach ($this->users as $user) {
            if ($user->accessCode === $accessCode) {
                return $user;
            }
        }
        return null;
    }
}
