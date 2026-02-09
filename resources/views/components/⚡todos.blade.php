<?php

use App\Models\Todo;
use Livewire\Component;

new class extends Component
{
    public string $title = '';

    /**
     * Create a new todo.
     */
    public function addTodo(): void
    {
        $this->validate([
            'title' => ['required', 'string', 'max:255'],
        ]);

        Todo::create([
            'title' => $this->title,
            'completed' => false,
        ]);

        $this->reset('title');
    }

    /**
     * Toggle a todo's completed state.
     */
    public function toggleTodo(Todo $todo): void
    {
        $todo->update([
            'completed' => ! $todo->completed,
        ]);
    }

    /**
     * Delete a todo.
     */
    public function deleteTodo(Todo $todo): void
    {
        $todo->delete();
    }

    /**
     * Get all todos ordered by newest first.
     */
    public function getTodosProperty()
    {
        return Todo::orderByDesc('created_at')->get();
    }
};
?>

<div class="max-w-xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold mb-1">Todo list</h1>
        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Add tasks, mark them as done, or remove them. All data is stored locally in SQLite.
        </p>
    </div>

    <form wire:submit.prevent="addTodo" class="flex gap-2 mb-6">
        <input
            type="text"
            wire:model.defer="title"
            placeholder="What do you need to do?"
            class="flex-1 px-3 py-2 rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-sm focus:outline-none focus:border-[#f53003] dark:focus:border-[#FF4433]"
        >
        <button
            type="submit"
            class="px-4 py-2 rounded-sm bg-[#1b1b18] text-white text-sm font-medium border border-black hover:bg-black hover:border-black dark:bg-[#eeeeec] dark:text-[#1C1C1A] dark:border-[#eeeeec] dark:hover:bg-white dark:hover:border-white transition-colors"
        >
            Add
        </button>
    </form>

    @if ($this->todos->isEmpty())
        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
            You have no todos yet. Add your first one above.
        </p>
    @else
        <ul class="space-y-2">
            @foreach ($this->todos as $todo)
                <li
                    wire:key="todo-{{ $todo->id }}"
                    class="flex items-center justify-between px-3 py-2 rounded-sm border border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]"
                >
                    <button
                        type="button"
                        wire:click="toggleTodo({{ $todo->id }})"
                        class="flex items-center gap-2 text-left flex-1"
                    >
                        <span
                            class="w-4 h-4 rounded-sm border border-[#dbdbd7] dark:border-[#3E3E3A] flex items-center justify-center bg-[#FDFDFC] dark:bg-[#161615]"
                        >
                            @if ($todo->completed)
                                <span class="w-2 h-2 rounded-sm bg-[#f53003] dark:bg-[#FF4433]"></span>
                            @endif
                        </span>
                        <span class="text-sm {{ $todo->completed ? 'line-through text-[#A1A09A]' : '' }}">
                            {{ $todo->title }}
                        </span>
                    </button>

                    <button
                        type="button"
                        wire:click="deleteTodo({{ $todo->id }})"
                        class="ml-3 text-xs text-[#f53003] dark:text-[#FF4433] hover:underline"
                    >
                        Delete
                    </button>
                </li>
            @endforeach
        </ul>
    @endif
</div>