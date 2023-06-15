<?php

// namespace App\Http\Livewire;

// use Livewire\Component;
// use App\Models\Parkzone;
// use App\Models\Category;
// use App\Models\Quartier;
// use App\Models\CategoryWiseParkzoneSlot;
// use App\Models\Sides;

// class Tariff extends Component
// {
//     public $quartiers;
//     public $categories;
//     public $parkzones = [];
//     public $parkzone = [];
//     public $selectedQuartier = null;
//     public $selectedParkzone = null;

//     public function mount()
//     {
//         $this->quartiers = Quartier::whereHas('parkzones', function ($query) {
//             $query->where('status', 1);
//         })->get();

//         $this->categories = Category::all();
//     }

//     public function updatedSelectedQuartier($quartier_id)
//     {
//         $this->parkzones = Parkzone::where('status', 1)
//             ->where('quartier_id', $quartier_id)
//             ->with('quartier')
//             ->get();

//         $this->selectedParkzone = null;
//         $this->parkzone = [];
//     }

    

//     public function updatedSelectedParkzone($index)
//     {
//         $parkzone_id = $this->parkzones[$index]->id;
//         $type = $this->parkzones[$index]->type;

//         $this->parkzone = Parkzone::where('id', $parkzone_id)
//             ->with('quartier')
//             ->first();

//         $this->parkzone->slots = $this->parkzone->slots($type)->get();
//     }

//     public function render()
//     {
//         return view('livewire.tariff');
//     }
// }





namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Parkzone;
use App\Models\Category;
use App\Models\Quartier;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\Sides;

class Tariff extends Component
{
    public $quartiers;
    public $categories;
    public $parkzones = [];
    public $parkzone = [];
    public $selectedQuartier = null;
    public $selectedParkzone = null;

    public function mount()
    {
        $this->quartiers = Quartier::whereHas('parkzones', function ($query) {
            $query->where('status', 1);
        })->get();

        $this->categories = Category::all();
    }

    public function updatedSelectedQuartier($quartier_id)
    {
        $this->parkzones = Parkzone::where('status', 1)
            ->where('quartier_id', $quartier_id)
            ->with('quartier')
            ->get();

        $this->selectedParkzone = null;
        $this->parkzone = [];
    }

    public function updatedSelectedParkzone($index)
    {
        if (isset($this->parkzones[$index])) {
            $parkzone_id = $this->parkzones[$index]->id;
            $type = $this->parkzones[$index]->type;

            $this->parkzone = Parkzone::where('id', $parkzone_id)
                ->with('quartier')
                ->first();

            $this->parkzone->slots = $this->parkzone->slots($type)->get();
        } else {
            $this->parkzone = null;
        }
    }

    public function render()
    {
        return view('livewire.tariff');
    }
}
