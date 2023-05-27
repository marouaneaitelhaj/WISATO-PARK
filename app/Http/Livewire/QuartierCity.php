<?php

namespace App\Http\Livewire;

use Livewire\Component;

class QuartierCity extends Component
{
    public $quartiers = [];
    public $cities = [];
    public $selectedCity = null;
    public $selectedQuartier = null;
    public function mount()
    {
        $this->cities = \App\Models\cities::all();
        
    }
    public function updatedSelectedCity($city)
    {
        $this->quartiers = \App\Models\Quartier::where('city_id', $city)->get();
    }
    public function render()
    {
        return view('livewire.quartier-city');
    }
}
