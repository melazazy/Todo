<div class="container mt-4">
    <form wire:submit.prevent="{{ $taskId ? 'updateTask' : 'addTask' }}" class="mb-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" wire:model="taskTitle" class="form-control" placeholder="Task Title" required>
            </div>
            <div class="col-md-1 p-0 m-auto">
                <label for="dueDate" class="form-label">Due Date</label>
            </div>
            <div class="col-md-3">
                <input type="date" wire:model="dueDate" class="form-control" id="dueDate" placeholder="Due Date">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100" type="submit">{{ $taskId ? 'Update Task' : 'Add Task' }}</button>
            </div>
        </div>

        <div class="mb-3">
            <textarea wire:model="taskDescription" class="form-control" placeholder="Task Description" rows="3"></textarea>
        </div>

        @if ($taskId)
            <div class="row mb-3">
                <div class="col-md-6">
                    <select wire:model="category_id" class="form-control">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <select wire:model="taskStatus" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        @endif

        <div class="mb-3">
            <label for="filter" class="form-label">Filter Tasks</label>
            <select wire:model.live="filter" class="form-control" id="filter">
                <option value="all">All Tasks</option>
                <option value="completed">Completed Tasks</option>
                <option value="pending">Pending Tasks</option>
            </select>
        </div>
    </form>

    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $this->filteredTasks->links() }}
    </div>

    <div class="list-group" id="taskList">
        @foreach($this->filteredTasks as $task)
            <div class="list-group-item task-card d-flex justify-content-between align-items-center {{ $task->trashed() ? 'text-muted' : '' }}" style="{{ $task->trashed() ? 'text-decoration: line-through;' : '' }}">
                <div>
                    <h5 class="mb-1">{{ $task->title }}</h5>
                    <p class="mb-1">{{ $task->description }}</p>
                    <small class="text-muted">Status: {{ $task->status }}</small>
                    <small class="text-muted">Due Date: {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</small>
                </div>
                <div>
                    @if ($task->trashed())
                        <button class="btn btn-danger btn-sm" wire:click="hardDeleteTask({{ $task->id }})">Delete Permanently</button>
                        <button class="btn btn-success btn-sm" wire:click="restoreTask({{ $task->id }})">Restore</button>
                    @else
                        <button class="btn btn-primary btn-sm" wire:click="editTask({{ $task->id }})">Edit</button>
                        <button class="btn btn-danger btn-sm" wire:click="deleteTask({{ $task->id }})">Delete</button>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
