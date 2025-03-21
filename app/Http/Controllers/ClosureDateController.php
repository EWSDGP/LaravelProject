<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ClosureDate;
use App\Models\Idea;

use Illuminate\Http\Request;

class ClosureDateController extends Controller
{
    public function __construct()
    {
        // Corrected syntax
        $this->middleware('permission:closure_date-list|closure_date-create|closure_date-edit|closure_date-delete', ["only" => ["index", "show"]]);
        $this->middleware('permission:closure_date-create', ["only" => ["create", "store"]]);
        $this->middleware('permission:closure_date-edit', ["only" => ["edit", "update"]]);
        $this->middleware('permission:closure_date-delete', ["only" => ["destroy"]]);
    }
    public function index()
    {
        $closureDates = ClosureDate::all();
        return view('closure_dates.index', compact('closureDates'));
    }

    
    public function create()
    {
        return view('closure_dates.create');
    }

   
    public function store(Request $request)
{
    $request->validate([
        'Idea_ClosureDate' => 'required|date|after_or_equal:today',
        'Comment_ClosureDate' => 'required|date|after_or_equal:today',
        'Academic_Year' => 'required|string|unique:closure_dates,Academic_Year',
    ]);

    ClosureDate::create($request->all());
    return redirect()->route('closure_dates.index')->with('success', 'Closure Date created successfully!');
}

   
    public function edit(ClosureDate $closureDate)
    {
        return view('closure_dates.edit', compact('closureDate'));
    }

    
    public function update(Request $request, ClosureDate $closureDate)
    {
        $request->validate([
            'Idea_ClosureDate' => 'required|date',
            'Comment_ClosureDate' => 'required|date',
            'Academic_Year' => 'required|string|unique:closure_dates,Academic_Year',
        ]);

        $closureDate->update($request->all());
        return redirect()->route('closure_dates.index')->with('success', 'Closure Date updated successfully!');
    }

    
    public function destroy($ClosureDate_id)
    {    
        $ClosureDate = ClosureDate::findOrFail($ClosureDate_id);

    // Check if the ClosureDate is associated with any ideas
    if (Idea::where('Closure_Date_id', $ClosureDate_id)->exists()) {
        return redirect()->route('closure_dates.index')->with("error", "Cannot delete this closure date because it is associated with one or more ideas.");
    }
        $closureDate = ClosureDate::findOrFail($ClosureDate_id); 
        $closureDate->delete();
        return redirect()->route('closure_dates.index')->with('success', 'Closure Date deleted successfully!');
    }
    
    
}
