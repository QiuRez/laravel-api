<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function getAll() {
        return Cache::remember('posts', 60*60*24, function() {
            return Post::all();
        });
    }

    public function createPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 402);
        }

        Post::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json([
            "message" => 'Создан новый пост'
        ], 200);

        
    }
}
