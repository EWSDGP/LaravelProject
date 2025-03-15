<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\User;
use App\Models\Idea;
use App\Mail\CommentNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class CommentController extends Controller
{   
    public function __construct()
    {
        // Corrected syntax
        $this->middleware('permission:comment-list|comment-submit|comment-edit|comment-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:comment-submit', ["only" => ["create", "store"]]);
        $this->middleware('permission:comment-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:comment-delete', ["only" => ["destroy"]]);
    }
    public function store(Request $request, $idea_id)
    {
        $request->validate([
            'comment_text' => 'required|string|max:500',
            // 'is_anonymous' => 'boolean',
        ]);

        $comment = Comment::create([
            'idea_id' => $idea_id,
            'user_id' => Auth::id(),
            'comment_text' => $request->comment_text,
            'is_anonymous' => $request->has('is_anonymous'),
        ]);

        $idea = Idea::find($idea_id);
        
        if ($idea) {
            $user = User::find($idea->user_id); 
            
            if ($user) {
                
                Mail::to($user->email)->send(new CommentNotification($idea));
            }
        }

        
        return back()->with('success', 'Comment added successfully!');

    }

    public function index($idea_id)
    {
        $comments = Comment::where('idea_id', $idea_id)->latest()->get();

        return response()->json([
            'comments' => $comments->map(function ($comment) {
                return [
                    'id' => $comment->comment_id,
                    'text' => $comment->comment_text,
                    'is_anonymous' => $comment->is_anonymous,
                    'user' => $comment->is_anonymous ? 'Anonymous' : $comment->user->name,
                    'created_at' => $comment->created_at->diffForHumans(),
                ];
            })
        ]);
    }
}

