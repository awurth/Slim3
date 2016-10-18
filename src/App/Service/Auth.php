<?php

namespace App\Service;

use App\Model\User;

class Auth
{
    /**
     * Get current user
     *
     * @return User|null
     */
    public function user()
    {
        if (isset($_SESSION['user_id'])) {
            return User::find($_SESSION['user_id']);
        }

        return null;
    }

    /**
     * Check if user is logged in
     *
     * @return bool
     */
    public function check()
    {
        return isset($_SESSION['user_id']);
    }

    public function attempt($username, $password)
    {
        $user = User::where('username', $username)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user_id'] = $user->id;
            return true;
        }

        return false;
    }

    /**
     * Logout current user
     */
    public function logout()
    {
        unset($_SESSION['user_id']);
    }
}