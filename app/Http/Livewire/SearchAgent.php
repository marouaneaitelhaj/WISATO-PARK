<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class SearchAgent extends Component
{
    public $search = '';
    public $agents = [];
    public $selectedAgents = [];
    public $selectedAgent;

    public function mount()
    {
        $this->agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'chef zone');
        })->where('name', 'like', '%' . $this->search . '%')->take(5)->get();
    }

    public function updatedSearch()
    {
        $this->agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'chef zone');
        })->where('name', 'like', '%' . $this->search . '%')->take(5)->get();
    }

    public function selectAgent($agentId)
    {
        $agent = User::find($agentId);
        if ($agent) {
            $this->selectedAgents[] = $agent;
        }
        $this->selectedAgent = null;
        
    }

    public function render()
    {
        return view('livewire.search-agent', [
            'search' => $this->search,
            'agents' => $this->agents,
            'selectedAgents' => $this->selectedAgents,
        ]);
    }
}
