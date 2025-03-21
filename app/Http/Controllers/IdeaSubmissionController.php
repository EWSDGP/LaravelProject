<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ClosureDate;
use App\Models\Vote;
use App\Mail\IdeaSubmitted;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Spatie\Permission\Models\Role;



class IdeaSubmissionController extends Controller
{
    public function __construct()
    {
        // Corrected syntax
        $this->middleware('permission:idea-list|idea-submit|idea-edit|idea-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:idea-submit', ["only" => ["create", "store"]]);
        $this->middleware('permission:idea-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:idea-delete', ["only" => ["destroy"]]);
    }
    public function index(Request $request)
    {
        $currentDate = now(); 
        
        $query = Idea::query();


        if ($request->has('category_id') && !empty($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }
    
       
        if ($request->has('department_id') && !empty($request->department_id)) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }
    
        $ideas = $query->with(['user', 'category', 'documents', 'comments', 'votes', 'closureDate'])
                       ->paginate(5); //latest 
    
        $categories = Category::all();  
        $departments = Department::all();  
    
       
        foreach ($ideas as $idea) {
            
            $closureDate = ClosureDate::find($idea->closure_date_id); 
    
           
            $idea->is_disabled = $currentDate->greaterThanOrEqualTo($closureDate->Idea_ClosureDate);
    
           
            $idea->can_comment = $currentDate->lessThanOrEqualTo($closureDate->Comment_ClosureDate);
        }
    
        return view('ideas.index', compact('ideas', 'categories', 'departments'))
                ->with('category_id', $request->category_id)
                ->with('department_id', $request->department_id);; 
    }
    
    
    
    
    
    


    public function create()
{
    $categories = Category::all();
    $closureDate = ClosureDate::latest()->first();  
    return view('ideas.create', compact('categories', 'closureDate'));
}

    


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'required|string|max:2500',
            'category_id' => 'required|exists:categories,category_id',
            'documents.*' => 'nullable|mimes:pdf,docx,txt,jpg,png|max:5120',
            'user_id' => 'required|exists:users,id',
            'terms' => 'accepted',
        ], [
            'title.required' => 'The title is required.',
            'title.max' => 'The title must not exceed 100 characters.',
            'description.required' => 'The description is required.',
            'description.max' => 'The description must not exceed 2,500 characters.',
            'category_id.required' => 'Please select a category.',
            'documents.*.max' => 'Each file must not exceed 5MB.',
            'terms.accepted' => 'You must accept the Terms & Conditions to submit.',
        ]);
    
        
        $closureDate = ClosureDate::latest()->first();
    
        // for second option
        // if ($closureDate && $closureDate->Idea_ClosureDate < now()) {
        //     return redirect()->route('ideas.index')->with('error', 'The idea submission period has closed.');
        // }
        //
        
        $idea = new Idea();
        $idea->title = $request->input('title');
        $idea->description = $request->input('description');
        $idea->category_id = $request->input('category_id');
        $idea->is_anonymous = $request->has('is_anonymous');
        $idea->user_id = $request->input('user_id');
        $idea->closure_date_id = $closureDate ? $closureDate->ClosureDate_id : null; 
        $idea->save();
    
       
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('documents');
                $idea->documents()->create(['file_path' => $path]);
            }
        }
    
        
        $managerRole = Role::where('name', 'QA_Coordinator')->first();
        $user = User::find($request->user_id);
    
        if ($managerRole && $user) {
            $manager = User::whereHas('roles', function ($query) use ($managerRole) {
                $query->where('role_id', $managerRole->id);
            })->where('department_id', $user->department_id)->first();
    
            if ($manager) {
                Mail::to($manager->email)->send(new IdeaSubmitted($idea));
            }
        }
    
        return redirect()->route('ideas.index')->with('success', 'Idea submitted successfully!');
    }

    
    
    
 
    public function show(string $id)
    {
       
        $idea = Idea::with('category', 'documents')->findOrFail($id);
        return view('ideas.show', compact('idea'));
    }

   
    public function edit(string $id)
    {
       
        $idea = Idea::findOrFail($id);
        $categories = Category::all();
        return view('ideas.edit', compact('idea', 'categories'));
    }

    
    public function update(Request $request, string $id)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'is_anonymous' => 'nullable|boolean',
        ]);

        
        $idea = Idea::findOrFail($id);
        $idea->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'is_anonymous' => $request->is_anonymous ?? false,
        ]);

       
        return redirect()->route('ideas.index')->with('success', 'Idea updated successfully!');
    }

   
    public function destroy(string $id)
    {
       
        $idea = Idea::findOrFail($id);
      
        $idea->documents()->delete();
        $idea->delete();

       
        return redirect()->route('ideas.index')->with('success', 'Idea deleted successfully!');
    }
    public function checkVote(Request $request,$idea_id)
{
    $user_id = $request->user()->id;

   
    $vote = Vote::where('idea_id', $idea_id)->where('user_id', $user_id)->first();

    
    return response()->json([
        'userHasVoted' => $vote ? true : false,
        'voteType' => $vote ? $vote->vote_type : null
    ]);
}
}
