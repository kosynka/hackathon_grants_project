<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{

    public function store(array $data) : void
    {
        User::create($data);
    }

    public function update(User $user, array $data) : void
    {
        $user->update($data);
    }

    public function findByPhone(string $phone)
    {
        return User::where('phone', $phone)->first();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function updateToken(User $user, $token)
    {
        $user->fb_token = $token;
        $user->save();
    }
}
