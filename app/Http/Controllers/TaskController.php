<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendings = Task::where('status', 'pending')->get();
        $started = Task::where('status', 'started')->get();
        $testing = Task::where('status', 'testing')->get();
        $completed = Task::where('status', 'completed')->get();
        return view('welcome', compact('pendings', 'started', 'testing', 'completed'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $taskRequest)
    {
    //    dd($taskRequest['title']);
        Task::create([
            'title' => $taskRequest['title'],
        ]);
        Session::flash('success', 'Task Added!');
        return redirect()->route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        $task->status = $request->status;
        $task->save();
        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);
        $task->delete();

        Session::flash('danger', 'Task Deleted!');
        return redirect()->route('index');
    }
}
