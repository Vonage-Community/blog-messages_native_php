<div>
    <div class="card">
        <div class="card-content">
            <form wire:submit.prevent="addTodo" class="form-row">
                <div class="form-input-wrapper">
                    <input
                        type="text"
                        wire:model.defer="title"
                        placeholder="Add a new task"
                        class="text-field"
                    >
                </div>
                <button type="submit" class="button">
                    <span class="material-icons small">add</span>
                </button>
            </form>
        </div>
    </div>

    @if ($this->todos->isEmpty())
        <div class="card">
            <div class="card-content">
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <span class="material-icons">check_circle_outline</span>
                    </div>
                    <div>No tasks yet. Add your first task above.</div>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-content" style="padding: 0;">
                @foreach ($this->todos as $todo)
                    <div class="list-item" wire:key="todo-{{ $todo->id }}">
                        <input
                            type="checkbox"
                            wire:click="toggleTodo({{ $todo->id }})"
                            {{ $todo->completed ? 'checked' : '' }}
                            class="checkbox"
                        >
                        
                        @if ($editingId === $todo->id)
                            <input
                                type="text"
                                wire:model.defer="editingTitle"
                                wire:keydown.enter="saveEdit"
                                wire:keydown.escape="cancelEdit"
                                class="text-field"
                                style="flex: 1; margin: 0; padding: 0; border-bottom: 1px solid rgba(0,0,0,0.12);"
                                autofocus
                            >
                        @else
                            <span class="list-item-text {{ $todo->completed ? 'completed' : '' }}" wire:click="startEdit({{ $todo->id }})" style="cursor: pointer;">
                                {{ $todo->title }}
                            </span>
                        @endif

                        <div class="action-buttons">
                            @if ($editingId === $todo->id)
                                <button
                                    type="button"
                                    wire:click="saveEdit"
                                    class="button-icon done"
                                    title="Save"
                                >
                                    <span class="material-icons small">check</span>
                                </button>
                                <button
                                    type="button"
                                    wire:click="cancelEdit"
                                    class="button-icon close"
                                    title="Cancel"
                                >
                                    <span class="material-icons small">close</span>
                                </button>
                            @else
                                <button
                                    type="button"
                                    wire:click="startEdit({{ $todo->id }})"
                                    class="button-icon edit"
                                    title="Edit"
                                >
                                    <span class="material-icons small">edit</span>
                                </button>
                                <button
                                    type="button"
                                    wire:click="deleteTodo({{ $todo->id }})"
                                    class="button-icon delete"
                                    title="Delete"
                                >
                                    <span class="material-icons small">delete</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
