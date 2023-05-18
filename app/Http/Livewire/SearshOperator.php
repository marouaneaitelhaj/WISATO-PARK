<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class SearshOperator extends Component
{
    public $search = '';
    public $operators = [];
    public $operator_id;
    public function mount()
    {
        $this->operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'operator');
        })->where('name', 'like', '%' . $this->search . '%')->get();
    }
    public function updatedSearch()
    {
        $this->operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'operator');
        })->where('name', 'like', '%' . $this->search . '%')->get();
    }
    public function render()
    {
        return view('livewire.searsh-operator', ['search' => $this->search, 'operators' => $this->operators]);
    }
}
