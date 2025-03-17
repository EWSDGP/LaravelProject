<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
       
        $ideasPerDepartment = Department::withCount('ideas')->orderByDesc('ideas_count')->get();

       
        $ideasPerStaff = User::whereHas('roles', function ($query) {
            $query->where('name', 'Staff'); 
        })->withCount('ideas')
            ->orderByDesc('ideas_count')
            ->limit(10)
            ->get();
        

        
        $ideasPerCategory = Idea::with('category')
        ->selectRaw('category_id, COUNT(*) as total')
        ->groupBy('category_id')
        ->get();
    

        
        $ideasPerYear = Idea::join('closure_dates', 'ideas.closure_date_id', '=', 'closure_dates.ClosureDate_id')
        ->selectRaw('closure_dates.Academic_Year as year, COUNT(*) as total')
        ->groupBy('closure_dates.Academic_Year')
        ->orderBy('closure_dates.Academic_Year', 'asc')
        ->get();


       
        $anonymousCount = Idea::where('is_anonymous', true)->count();
        $namedCount = Idea::where('is_anonymous', false)->count();

        
        $activeUsersCount = User::has('ideas')->count();

     
        $staffUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Staff'); 
        });


        $totalUsers = $staffUsers->count();


        $onlyVotedOrCommented = User::whereHas('roles', function ($query) {
            $query->where('name', 'Staff');
        })->whereDoesntHave('ideas')
        ->where(function ($query) {
            $query->whereHas('comments')->orWhereHas('votes');
        })
        ->count();


        $inactiveUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'Staff');
        })->whereDoesntHave('ideas')
        ->whereDoesntHave('comments')
        ->whereDoesntHave('votes')
        ->count();

            
            $mostPopularIdeas = Idea::with('user') 
                ->withCount(['votes as likes' => function ($query) {
                    $query->where('vote_type', 'like');
                }])
                ->orderByDesc('likes') 
                ->limit(10)
                ->get();

        
            $leastPopularIdeas = Idea::with('user') 
                ->withCount([
                    'votes as likes' => function ($query) {
                        $query->where('vote_type', 'like');
                    },
                    'votes as dislikes' => function ($query) {
                        $query->where('vote_type', 'dislike');
                    }
                ])
                ->orderByDesc('dislikes') 
                ->limit(10)
                ->get();


                return view('statistics.index', compact(
                    'ideasPerDepartment',
                    'ideasPerStaff',
                    'ideasPerCategory',
                    'ideasPerYear',
                    'anonymousCount',
                    'namedCount',
                    'activeUsersCount',
                    'totalUsers',
                    'onlyVotedOrCommented',
                    'inactiveUsers',
                    'mostPopularIdeas',
                    'leastPopularIdeas'
                ));
     }
}
