<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Idea;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function vote(Request $request, $idea_id)
    {
        $user_id = $request->user()->id; 
        $vote_type = $request->input('vote_type'); 
    
        if (!in_array($vote_type, ['like', 'dislike', 'remove'])) {
            return response()->json(['error' => 'Invalid vote type'], 400);
        }
    
        
        $idea = Idea::findOrFail($idea_id);
    
        
        if ($vote_type == 'remove') {
            $existingVote = Vote::where('idea_id', $idea_id)
                                ->where('user_id', $user_id)
                                ->first();
    
            if ($existingVote) {
                $existingVote->delete(); 
            }
        } else {
            
            $existingVote = Vote::where('idea_id', $idea_id)
                                ->where('user_id', $user_id)
                                ->first();
    
            if ($existingVote) {
                
                if ($existingVote->vote_type != $vote_type) {
                    $existingVote->vote_type = $vote_type;
                    $existingVote->save();
                }
            } else {
               
                Vote::create([
                    'idea_id' => $idea_id,
                    'user_id' => $user_id,
                    'vote_type' => $vote_type,
                ]);
            }
        }
    
       
        $like_count = Vote::where('idea_id', $idea_id)->where('vote_type', 'like')->count();
        $dislike_count = Vote::where('idea_id', $idea_id)->where('vote_type', 'dislike')->count();
    
        return response()->json([
            'status' => $vote_type == 'remove' ? 'removed' : 'voted',
            'like_count' => $like_count,
            'dislike_count' => $dislike_count
        ]);
    }
    
    
    
    
    
    
    
}

