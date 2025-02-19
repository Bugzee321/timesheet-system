<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    /**
     * List users with pagination.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listUsersPaginated(int $perPage = 10)
    {
        return User::paginate($perPage);
    }

    /**
     * Create a new user.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    /**
     * Update an existing user.
     *
     * @param \App\Models\User $user
     * @param array $data
     * @return \App\Models\User
     */
    public function updateUser(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    /**
     * Delete a user.
     *
     * @param \App\Models\User $user
     * @return bool|null
     * @throws \Exception
     */
    public function deleteUser(User $user)
    {
        return $user->delete();
    }

    /**
     * Get a user by email.
     *
     * @param string $email
     * @return \App\Models\User
     */
    public function getUserByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }
}

