<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\UserLogin;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function authenticated(Request $request, $user)
    {

        UserLogin::create([
            'user_id' => $user->id,
            'login_date' => now()->toDateString(), 
            'login_time' => now()->toTimeString(), 
        ]);

       
        $role = $user->getRoleNames()->first();
        if ($role === 'Admin') {
            session()->put('title', 'Admin Dashboard'); 
            return redirect()->route('statistics.index');
        }
        else if($role === 'Manager') {
            session()->put('title', 'Manager Dashboard'); 
            return redirect()->route('statistics.index');
        }
        else if($role === 'QA_Coordinator') {
            session()->put('title', 'QA Coordinator Dashboard'); 
            return redirect()->route('statistics.index');
        }


        session()->put('title', 'User Dashboard'); 
        return redirect()->route('ideas.index');
    }
}
