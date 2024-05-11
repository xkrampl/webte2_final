<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;

class ArchivePolicy
{
    public function before(?User $user)
    {
        if ($user?->is_admin) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Question $question): true
    {
        return $user->id === $question->user->id;
    }
}
