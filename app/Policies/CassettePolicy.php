<?php

namespace App\Policies;

use App\Models\Cassette;
use App\Models\User;

class CassettePolicy
{
    // Boleh read hanya untuk pemilik, atau kaset yang publik
    public function view(User $user, Cassette $cassette): bool
    {
        return $user->id === $cassette->user_id
            || $cassette->visibility === 'public';
    }

    // Boleh update jika pemilik
    public function update(User $user, Cassette $cassette): bool
    {
        return $user->id === $cassette->user_id;
    }

    // Boleh delete jika pemilik
    public function delete(User $user, Cassette $cassette): bool
    {
        return $user->id === $cassette->user_id;
    }
}