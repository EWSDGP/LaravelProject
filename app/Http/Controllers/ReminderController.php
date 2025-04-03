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
        $this->middleware('auth');
    }


public function index()
{
    $user = Auth::user();

    $department = Department::withCount('ideas')->where('id', $user->department_id)->first();

    $usersWithIdeaCount = User::withCount('ideas')
                              ->where('department_id', $user->department_id)
                              ->get();

    return view('reminder.index', compact('user', 'department', 'usersWithIdeaCount'));
}

public function sendReminderEmail($userId)
{
    $user = User::findOrFail($userId);

    Mail::to($user->email)->send(new ReminderEmail());
    return redirect()->route('reminder.index')->with('success', 'Operation completed successfully!');

}

}