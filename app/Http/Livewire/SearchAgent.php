<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;
use App\Models\AgentInParkzone;

class SearchAgent extends Component
{
    public $agents = [];
    public $parkzone;
    public $html = '';
    public $selectedAgents = [];
    public $gardien = [];
    public $selectedGardien = [];

    public function mount()
    {
        if ($this->parkzone !== null) {
            $this->selectedAgents = AgentInParkzone::where('parkzone_id', $this->parkzone->id)->with('agent')->get();
        }
        $this->fetchAgents();
    }

    public function updatedSelectedAgent($agentId)
    {
        $this->selectAgent($agentId);
    }

    public function selectAgent($agentId)
    {
        if ($agentId && !$this->isAgentSelected($agentId)) {
            $agent = User::find($agentId);
            $this->selectedAgents[] = $agent;
            $this->sweetAlert('success', 'Agent selected successfully!');
        } else {
            $this->sweetAlert('error', 'Agent already selected!');
        }
    }


    private function isAgentSelected($agentId)
    {
        return collect($this->selectedAgents)->contains('id', $agentId);
    }

    private function sweetAlert($type, $message)
    {
        $this->dispatchBrowserEvent('show-sweet-alert', [
            'type' => $type,
            'message' => $message
        ]);
    }

    private function fetchAgents()
    {
        $this->agents = User::whereHas('roles', function ($query) {
            $query->where('name', 'chef zone');
        })->get();
    }

    public function render()
    {
        return view('livewire.search-agent', [
            'agents' => $this->agents,
            'selectedAgents' => $this->selectedAgents,
        ]);
    }
}
