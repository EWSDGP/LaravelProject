<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Idea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller {
    public function store(Request $request, $idea_id) {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);
    
        $idea = Idea::findOrFail($idea_id);
    
       
        if ($idea->user_id == Auth::id()) {
            return back()->with('error', 'You cannot report your own idea.');
        }
    
        Report::create([
            'user_id' => Auth::id(),
            'idea_id' => $idea_id,
            'reason' => $request->reason,
        ]);
    
        return back()->with('success', 'Report submitted successfully.');
    }
    
}
