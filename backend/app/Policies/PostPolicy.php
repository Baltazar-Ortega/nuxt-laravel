<?php

namespace App\Policies;

use App\User;
use App\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    public function update(User $user, Post $post) {
        return $user->ownsPost($post); // Retorna true si si matchea. checa el User de app/
    }

    public function destroy(User $user, Post $post) {
        return $user->ownsPost($post);
    }

    public function like(User $user, Post $post) {
        return !$user->ownsPost($post);
    }
}
