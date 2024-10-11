<?php

namespace App\Http\Controllers;

use App\Models\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class NameController extends Controller
{
    // Display form and list of names
    public function index()
    {
        $names = Name::all();
        return view('names.index', compact('names'));
    }

    // Save name to the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Name::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Name saved successfully!');
    }

    public function export()
    {
        $names = Name::all()->pluck('name'); // Get all names
    
        // Create a JavaScript content with a variable containing the data
        $jsContent = 'const names = ' . $names->toJson(JSON_PRETTY_PRINT) . ';';
    
        $fileName = 'names.js';  // Define the filename as a JS file
        $headers = [
            'Content-type'        => 'application/javascript',
            'Content-Disposition' => 'attachment; filename=' . $fileName,
        ];
    
        return Response::make($jsContent, 200, $headers);
    }
    
}
