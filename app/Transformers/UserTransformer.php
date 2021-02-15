<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;
use App\Transformers\PostTransformer;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'posts'
    ];

    // menggunakan transformer salah satuny agar api selalu konsisten pada pengguna
    public function transform(User $user)
    {
        return [
            'id'=>$user->id,
            'nama'=>$user->name,
            'email'=>$user->email
        ];
    }

    // untuk menampilkan post milik user pada json "user"
    public function includePosts(User $user)
    {
        $posts = $user->posts;
        return $this->collection($posts, new PostTransformer);
        
    }
}