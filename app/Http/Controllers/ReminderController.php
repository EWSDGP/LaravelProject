<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderEmail;
use App\Models\Department;
use App\Models\Idea;
use App\Models\User;

class ReminderController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('permission:coordinator-statistics', ["only" => ["index","endReminderEmail"]]);
  
    }


public function index()
{
    $user = Auth::user();

    $department = Department::withCount('ideas')->where('id', $user->department_id)->first();

    $usersWithIdeaCount = User::withCount('ideas')
                          ->where('department_id', $user->department_id)
                          ->where('id', '!=', $user->id)
                          ->get();

    return view('reminder.index', compact('user', 'department', 'usersWithIdeaCount'));
}

public function sendReminderEmail($userId)
{
    $user = User::findOrFail($userId);

    Mail::to($user->email)->send(new ReminderEmail());
    session()->flash('success', 'Reminder email sent successfully!');

    return redirect()->route('reminder.index');
}

}