<?php

namespace App\Policies;

use App\User;
use App\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {

    }

    public function update(User $user, Topic $topic) {
        return $user->ownsTopic($topic); // Retorna true si si matchea
    }

    public function destroy(User $user, Topic $topic) {
        return $user->ownsTopic($topic);
    }
}
