<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination; // Import the WithPagination trait


class TaskManager extends Component
{
    use WithPagination; // Use the WithPagination trait

    public $tasks;
    public $taskTitle;
    public $taskDescription;
    public $taskId;
    public $categories;
    public $taskStatus;
    public $category_id;
    public $dueDate;
    public $filter = 'all';

    public function mount()
    {
        $this->tasks = Task::where('user_id', auth::id())->orderBy('created_at', 'desc')->get();
        $this->categories = Category::all();
    }

    public function addTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'dueDate' => 'nullable|date', // Validate due date
        ]);

        Task::create([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'status' => 'pending',
            'user_id' => auth::id(),
            'category_id' => null,
            'due_date' => !empty($this->dueDate) ? $this->dueDate : null, // Set to null if empty
        ]);

        $this->resetInput();
        $this->tasks = Task::where('user_id', auth::id())->get(); // Refresh the task list
    }

    public function editTask($id)
    {
        $task = Task::find($id);
        $this->taskId = $task->id;
        $this->taskTitle = $task->title;
        $this->taskDescription = $task->description;
        $this->taskStatus = $task->status;
        $this->category_id = $task->category_id; // Load the category for the task
        $this->dueDate = $task->due_date; // Load the due date for the task
    }
    public function updateTask()
    {
        $this->validate([
            'taskTitle' => 'required|string|max:255',
            'taskDescription' => 'nullable|string',
            'taskStatus' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'dueDate' => 'nullable|date', // Validate due date
            ]);

        $task = Task::find($this->taskId);
        $task->update([
            'title' => $this->taskTitle,
            'description' => $this->taskDescription,
            'status' => $this->taskStatus,
            'category_id' => $this->category_id,
            'due_date' => !empty($this->dueDate) ? $this->dueDate : null, // Set to null if empty
        ]);

        $this->resetInput();
        $this->tasks = Task::where('user_id', Auth::id())->get(); // Refresh the task list
    }
    public function getFilteredTasksProperty()
{
    if ($this->filter === 'completed') {
        return Task::where('user_id', auth::id())->where('status', 'completed')->orderBy('created_at', 'desc')->paginate(5);
    } elseif ($this->filter === 'pending') {
        return Task::where('user_id', auth::id())->where('status', 'pending')->orderBy('created_at', 'desc')->paginate(5);
    }
    elseif ($this->filter === 'all') {
        return Task::withTrashed()->where('user_id', Auth::id())->orderBy('created_at', 'desc')->paginate(5); // Include soft-deleted tasks
    }

    return Task::where('user_id', auth::id())->orderBy('created_at', 'desc')->get(); // Return all tasks
}
public function updatedFilter()
{
    $this->resetPage(); // Reset to the first page when the filter changes
}
    public function deleteTask($id)
    {
        Task::find($id)->delete();
        $this->tasks = Task::where('user_id', auth::id())->get(); // Refresh the task list
    }
    public function restoreTask($id)
    {
        $task = Task::withTrashed()->find($id); // Get the soft-deleted task
        if ($task) {
            $task->restore(); // Restore the task
            $this->tasks = Task::where('user_id', Auth::id())->get(); // Refresh the task list
        }
    }

    public function hardDeleteTask($id)
{
    $task = Task::withTrashed()->find($id); // Get the soft-deleted task
    if ($task) {
        $task->forceDelete(); // Permanently delete the task
        $this->tasks = Task::where('user_id', Auth::id())->get(); // Refresh the task list
    }
}
    private function resetInput()
    {
        $this->taskTitle = '';
        $this->taskDescription = '';
        $this->taskId = null;
        $this->taskStatus = 'pending';
        $this->category_id = null; // Reset category
        $this->dueDate = '';
    }

    public function render()
    {
        return view('livewire.task-manager');
    }
}
