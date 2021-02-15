<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use App\Transformers\PostTransformer;

class PostController extends Controller
{
    // method untuk menambahkan postingan oleh pengguna
    // diperlukan Authorization
    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required',
        ]);
        $post = Post::create([
            'user_id'=>Auth::user()->id,
            'title'=>$request->title,
            'content'=>$request->content
        ]);

        $response = fractal()
            ->item($post)
            ->transformWith(new PostTransformer)
            ->toArray();

        return response()->json($response,201);
    }


    // method untuk mengubah postingan oleh pengguna
    // diperlukan Authorization
    public function update(Request $request,Post $post)
    {

        $this->authorize('update',$post);
        $post->title=$request->get('title',$request->title);
        $post->content=$request->get('content',$request->content);
        $post->save();


        return fractal()
            ->item($post)
            ->transformWith(new PostTransformer)
            ->toArray();
    }

    // method untuk menghapus postingan oleh pengguna
    // diperlukan Authorization
    public function delete(Request $request,Post $post)
    {
        $this->authorize('delete',$post);
        $post->delete();

        return response()->json([
            'message'=>'Postingan berhasil di hapus'
        ]);
    }
}
