<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\BannedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller {
    public function __construct()
    {
        
        $this->middleware('permission:manage-reports', ["only" => ["index", "store","destroy","banUser","unbanUser"]]);
  
    }
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

     public function index() {
        $reports = Report::with(['user', 'idea.user'])->latest()->get();
        return view('reports.index', compact('reports'));
    }
    

   
    public function destroy($id) {
        $report = Report::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report deleted successfully.');
    }

    public function banUser($user_id) {
        $user = User::findOrFail($user_id);
        $user->is_banned = true;
        $user->save();
    
        if (Auth::id() === $user->id) {
            Auth::logout();
        }
        Mail::to($user_id->email)->send(new BannedNotification($user));
    
        return back()->with('success', 'User has been banned.');
    }
    
    
    public function unbanUser($user_id) {
        $user = User::findOrFail($user_id);
        $user->is_banned = false;
        $user->save();
    
        return back()->with('success', 'User has been unbanned.');
    }
    
    
}
