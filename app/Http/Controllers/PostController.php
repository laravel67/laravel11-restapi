<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts, 200);
        // return view('posts', compact('posts'));
    }

    public function show($id)
    {
        $data = Post::find($id);
        if (is_null($data)) {
            return  response()->json([
                'message' => 'Post Tidak ada'
            ], 404);
        }
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        try {
            $validateDate = $request->validate([
                'title' => 'required|min:5|max:255',
                'body' => 'required'
            ]);
            $post = Post::create($validateDate);
            return response()->json($post,  201);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors()
            ], 400);
        }
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());
        return response()->json($post, 200);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json("berhasil dihapus", 200);
    }
}
