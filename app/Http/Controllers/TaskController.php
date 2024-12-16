<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())->withTrashed()->orderBy('created_at', 'desc')->get();
        $categories = Category::all();
        return view('dashboard', compact('tasks', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => 'pending',
            'user_id' => Auth::id(),
            'category_id' => null,
            'due_date' => !empty($request->due_date) ? $request->due_date : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task added successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'due_date' => 'nullable|date',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'due_date' => !empty($request->due_date) ? $request->due_date : null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Task updated successfully.');
    }
    public function editTask($id)
    {
        $task = Task::findOrFail($id);
        $tasks = Task::where('user_id', Auth::id())->withTrashed()->get();
        $categories = Category::all();

        return view('dashboard', [
            'taskId' => $task->id,
            'taskTitle' => $task->title,
            'taskDescription' => $task->description,
            'taskStatus' => $task->status,
            'category_id' => $task->category_id,
            'dueDate' => $task->due_date ? $task->due_date->format('Y-m-d') : null,
            'tasks' => $tasks,
            'categories' => $categories,
        ]);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('dashboard')->with('success', 'Task deleted successfully.');
    }

    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        if ($task) {
            $task->restore();
            return redirect()->route('dashboard')->with('success', 'Task restored successfully.');
        }
    }

    public function hardDelete($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        if ($task) {
            $task->forceDelete();
            return redirect()->route('dashboard')->with('success', 'Task permanently deleted.');
        }
    }
}
