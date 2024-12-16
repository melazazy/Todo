
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO List</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('https://example.com/your-background-image.jpg');
            /* Replace with your image URL */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #333;
            /* Adjust text color for better contrast */
        }

        .container {
            background-color: rgba(255, 255, 255, 0.8);
            /* Semi-transparent white background for better readability */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .task-card {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }

        .task-card:hover {
            transform: scale(1.02);
        }

        .btn-add {
            background-color: #28a745;
            color: white;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-add:hover,
        .btn-delete:hover {
            opacity: 0.8;
        }

        .task-input {
            border-radius: 0.5rem;
        }

        .header-title {
            color: #007bff;
            margin-bottom: 20px;
        }

    </style>
</head>


<div class="container mt-4">
    <h1 class="header-title">Your Tasks</h1>

    @if(isset($taskId))
    <form action="{{ route('tasks.update', $taskId) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" name="title" class="form-control" placeholder="Task Title" value="{{ $taskTitle }}" required>
            </div>
            <div class="col-md-6">
                <input type="text" name="description" class="form-control" placeholder="Task Description" value="{{ $taskDescription }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <input type="date" name="due_date" class="form-control" value="{{ $dueDate }}">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control" required>
                    <option value="pending" {{ $taskStatus == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $taskStatus == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-control">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">Update Task</button>
            </div>
        </div>
    </form>
@else
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" name="title" class="form-control" placeholder="Task Title" required>
            </div>
            {{-- <div class="col-md-3">
                <input type="date" name="due_date" class="form-control">
            </div> --}}
            <div class="col-md-3">
                <button class="btn btn-primary w-100" type="submit">Add Task</button>
            </div>
            <div class="col-md-6">
                <textarea name="description" class="form-control" placeholder="Task Description" required></textarea>
            </div>
        </div>
    </form>
@endif
    <div class="list-group" id="taskList">
        @foreach($tasks as $task)
            <div class="list-group-item task-card d-flex justify-content-between align-items-center {{ $task->trashed() ? 'text-muted' : '' }}">
                <div>
                    <h5 class="mb-1">{{ $task->title }}</h5>
                    <p class="mb-1">{{ $task->description }}</p>
                    <small class="text-muted">Due Date: {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</small>
                </div>
                <div>
                    @if ($task->trashed())
                        <form action="{{ route('tasks.restore', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button class="btn btn-success btn-sm" type="submit">Restore</button>
                        </form>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete Permanently</button>
                        </form>
                    @else
                        <form action="{{ route('tasks.edit', $task->id) }}" method="GET" style="display:inline;">
                            <button class="btn btn-primary btn-sm" type="submit">Edit</button>
                        </form>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
