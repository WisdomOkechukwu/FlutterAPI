<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($id){
        $post = Post::find($id);

        if(!$post){
            return response([
                'message' => 'Post not found',
            ]);
        }

        return response([
            'comments' => $post->comments()->with('user:id,name,image')->get(),
        ], 200);
    }

    public function store(Request $request,$id){
        $post = Post::find($id);

        if(!$post){
            return response([
                'message' => 'Post not found',
            ]);
        }

        $attrs = $request->validate([
            'comment' => 'required|string'
        ]);

        Comment::create([
            'comment' => $attrs['comment'],
            'post_id' =>$id,
            'user_id' => auth()->user()->id, 
        ]);

        return response([
            'message' => 'Comment created',
            'post' => $post->comments()->with('user:id,name,image')->get(),
        ], 200);
    }

    public function update(Request $request,$id){
        $comment = Comment::find($id);
        if(!$comment){
            return response([
                'message' => 'comment not found',
            ]);
        }
        if($comment->user_id != auth()->user()->id){
            return response([
                'message' => 'Permission Denied',
            ], 403);
        }
        $attrs = $request->validate([
            'comment' => 'required|string'
        ]);

        $comment->update([
            'comment' => $attrs['comment'],
        ]);

        return response([
            'message' => 'Comment Updated'
        ], 200);

    }

    public function destroy($id){
        $comment = Comment::find($id);
        if(!$comment){
            return response([
                'message' => 'comment not found',
            ]);
        }
        if($comment->user_id != auth()->user()->id){
            return response([
                'message' => 'Permission Denied',
            ], 403);
        }

        $comment->delete();

        return response([
            'message' => 'Comment Deleted'
        ], 200);
    }
}

