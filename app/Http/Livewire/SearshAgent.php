<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class SearshAgent extends Component
{
    public $search = '';
    public $agents = [];
    public $agent_id;
    public function mount()
    {
        $this->agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->where('name', 'like', '%' . $this->search . '%')->get();
    }
    public function updatedSearch()
    {
        $this->agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        })->where('name', 'like', '%' . $this->search . '%')->get();
    }
    public function render()
    {
        return view('livewire.searsh-agent', ['search' => $this->search, 'agents' => $this->agents]);
    }
}