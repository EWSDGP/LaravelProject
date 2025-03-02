<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Document;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\ClosureDate;
use App\Models\Vote;


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
    public function index()
    {
     
        $ideas = Idea::with('category', 'user')->paginate(5);

        return view('ideas.index', compact('ideas'));
    }


    public function create()
    {
      
        $categories = Category::all();
        return view('ideas.create', compact('categories'));
    }


    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,category_id',
            'documents.*' => 'nullable|mimes:pdf,docx,txt,jpg,png|max:2048', 
            'user_id' => 'required|exists:users,id' 
        ]);
    
        
        $closureDate = ClosureDate::latest()->first(); 
    
   
        $idea = new Idea();
        $idea->title = $request->input('title');
        $idea->description = $request->input('description');
        $idea->category_id = $request->input('category_id');
        $idea->is_anonymous = $request->input('is_anonymous', false);
        $idea->user_id = $request->input('user_id'); 
        $idea->closure_date_id = $closureDate->ClosureDate_id; 
        $idea->save();
    
        
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $path = $document->store('documents'); 
              
                $idea->documents()->create(['file_path' => $path]);
            }
        }
        $name =  $request->input('user_name'); 
        $department_id =  $request->input('department_name'); 
       
        // thu department yae coordiantor 
    // chatgpt sql 
    
    // staff yae name   user->role->qa coordinator->email 
        // idea->user_id where  = users->id
        //users->name  
        //staff position nat Oakkar name email  email 
        //
        //nat qa coordinator nat poh ya mal 
     // email notification -> qa coordinator role qa coordinator nat name ta khu khu 
        
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
