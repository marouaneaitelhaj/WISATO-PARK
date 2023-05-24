<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;
use Illuminate\Support\Facades\Session;


class SearchAgent extends Component
{
    public $search = '';
    public $agents = [];
    public $selectedAgents = [];
    public $selectedAgent;

    public function mount()
    {
        $this->fetchAgents();
    }

    public function updatedSearch()
    {
        $this->fetchAgents();
    }

    public function selectAgent($agentId)
    {
        $agent = User::find($agentId);
        if ($agent && !$this->isAgentSelected($agentId)) {
            $this->selectedAgents[] = $agent;
            $this->sweetAlert('success', 'Agent selected successfully!');
        } else {
            $this->sweetAlert('error', 'Agent already selected!');
        }
        
        $this->selectedAgent = null;
    }


    private function isAgentSelected($agentId)
    {
        return collect($this->selectedAgents)->contains(function ($selectedAgent) use ($agentId) {
            return $selectedAgent['id'] == $agentId;
        });
    }
    private function sweetAlert($type, $message)
    {
        $this->dispatchBrowserEvent('show-sweet-alert', [
            'type' => $type,
            'message' => $message
        ]);
    }



    public function removeAgent($agentId)
    {
        unset($this->selectedAgents[$agentId]);
    }

    public function render()
    {
        return view('livewire.search-agent', [
            'search' => $this->search,
            'agents' => $this->agents,
            'selectedAgents' => $this->selectedAgents,
        ]);
    }

    private function fetchAgents()
    {
        $this->agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'chef zone');
        })->where('name', 'like', '%' . $this->search . '%')->take(3)->get();
    }
}
