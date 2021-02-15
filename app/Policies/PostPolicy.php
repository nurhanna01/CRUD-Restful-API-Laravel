<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    // policy update agar pengguna hanya bisa mengubah miliknya sendiri
    public function update(User $user,Post $post)
    {
        return $user->ownsPost($post);
    }

    // policy delte agar pengguna hanya bisa menghapus miliknya sendiri
    public function delete(User $user,Post $post)
    {
        return $user->ownsPost($post);
    }
}
