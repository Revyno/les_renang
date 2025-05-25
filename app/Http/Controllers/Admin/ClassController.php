<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Instructor;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = Classes::with('instructors')->latest()->paginate(10);
        return view('admin.classes.index', compact('classes'));
    }

    public function create()
    {
        $instructors = Instructor::all();
        return view('admin.classes.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sessions' => 'required|integer',
            'duration_weeks' => 'required|integer',
            'instructors' => 'required|array',
        ]);

        $class = Classes::create($validated);
        $class->instructors()->sync($request->instructors);

        return redirect()->route('admin.classes.index')->with('success', 'Class created successfully');
    }

    public function edit(Classes $class)
    {
        $instructors = Instructor::all();
        return view('admin.classes.edit', compact('class', 'instructors'));
    }

    public function update(Request $request, Classes $class)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'sessions' => 'required|integer',
            'duration_weeks' => 'required|integer',
            'instructors' => 'required|array',
        ]);

        $class->update($validated);
        $class->instructors()->sync($request->instructors);

        return redirect()->route('admin.classes.index')->with('success', 'Class updated successfully');
    }

    public function destroy(Classes $class)
    {
        $class->delete();
        return redirect()->route('admin.classes.index')->with('success', 'Class deleted successfully');
    }
}