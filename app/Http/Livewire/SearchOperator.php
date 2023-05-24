<?php

namespace App\Http\Livewire;

use App\User;
use Livewire\Component;

class searchOperator extends Component
{
    public $search = '';
    public $operators = [];
    public $selectedOperators = [];
    public $operator_id;
    public function mount()
    {
        $this->operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'gardien');
        })->where('name', 'like', '%' . $this->search . '%')->take(3)->get();
    }
    public function updatedSearch()
    {
        $this->operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'gardien');
        })->where('name', 'like', '%' . $this->search . '%')->take(3)->get();
    }
    public function add($operator)
    {
        // check if operator already exists
        foreach ($this->selectedOperators as $index => $selectedOperator) {
            if ($selectedOperator['id'] == $operator['id']) {
                return;
            }
        }
        array_push($this->selectedOperators, [
            'id' => $operator['id'],
            'name' => $operator['name'],
        ]);
        // $this->search = '';
        $this->operators = User::whereHas('roles', function ($query) {
            $query->where('name', 'gardien');
        })->where('name', 'like', '%' . $this->search . '%')->take(3)->get();
    }
    public function delete($index)
    {
        unset($this->selectedOperators[$index]);
    }
    public function render()
    {
        return view('livewire.search-operator', ['search' => $this->search, 'operators' => $this->operators]);
    }
}
