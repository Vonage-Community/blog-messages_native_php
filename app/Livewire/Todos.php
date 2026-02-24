<?php

namespace App\Livewire;

use App\Models\Todo;
use App\Services\VonageService;
use Livewire\Component;
use Vonage\Client;
use Vonage\Messages\Channel\SMS\SMSText;

class Todos extends Component
{
    public string $title = '';
    public ?int $editingId = null;
    public string $editingTitle = '';

    protected ?VonageService $vonageService = null;

    protected function getVonageService(): VonageService
    {
        if ($this->vonageService === null) {
            $this->vonageService = app(VonageService::class);
        }

        return $this->vonageService;
    }

    public function getVonageClient(): Client
    {
        return $this->getVonageService()->getClient();
    }

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

    public function startEdit(Todo $todo): void
    {
        $this->editingId = $todo->id;
        $this->editingTitle = $todo->title;
    }

    public function saveEdit(): void
    {
        if (! $this->editingId) {
            return;
        }

        $this->validate([
            'editingTitle' => ['required', 'string', 'max:255'],
        ]);

        $todo = Todo::find($this->editingId);

        if ($todo) {
            $todo->update(['title' => $this->editingTitle]);
        }

        $this->editingId = null;
        $this->editingTitle = '';
    }

    public function cancelEdit(): void
    {
        $this->editingId = null;
        $this->editingTitle = '';
    }

    public function toggleTodo(Todo $todo): void
    {
        $todo->update([
            'completed' => ! $todo->completed,
        ]);

        if ($todo->completed) {
            $sms = new SMSText(
                config('services.vonage.vonage_to'),
                'Vonage ToDo',
                $todo->title
            );

            $this->getVonageClient()->messages()->send($sms);
        }
    }

    public function deleteTodo(Todo $todo): void
    {
        $todo->delete();

        if ($this->editingId === $todo->id) {
            $this->cancelEdit();
        }
    }

    public function getTodosProperty()
    {
        return Todo::orderByDesc('created_at')->get();
    }

    public function render()
    {
        return view('livewire.todos');
    }
}
