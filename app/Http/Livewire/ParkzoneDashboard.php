<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Parkzone;
use App\Models\FloorSlot;
use App\Models\Category;
use App\Models\Quartier;
use App\Models\CategoryWiseParkzoneSlot;
use App\Models\Floor;
use App\Models\Side_slot;
use App\Models\Sides;
use App\View\Components\side;

class ParkzoneDashboard extends Component
{
    public $quartiers;
    public $modeshow = 'single';
    public $categories;
    public $parkzones = [];
    public $parkzone = [];
    public $selectedQuartier = null;
    public $selectedParkzone = null;
    public $totalSlots = 0;
    public $parkzone_tariff = [];

    public function mount()
    {
        $user = auth()->user()->id;
        if ($user == 1) {
            $this->quartiers = Quartier::whereHas('parkzones', function ($query) {
                $query->where('status', 1);
            })->get();
        } else {
            $this->quartiers = Quartier::whereHas('parkzones', function ($query) {
                $query->where('status', 1)
                    ->whereHas('agent_inparkzone', function ($query) {
                        $query->where('agent_id', auth()->user()->id);
                    });
            })->get();
        }
        $this->categories = Category::all();
        // dd($this->categories);
    }
    public function getfloors($parkzone_id)
    {
        $floor = Floor::where('parkzone_id', $parkzone_id)->get();
        foreach ($floor as $f) {
            switch ($f->level) {
                case 0:
                    $f->level = 'Ground Floor';
                    break;
                case 1:
                    $f->level = 'First Floor';
                    break;
                case 2:
                    $f->level = 'Second Floor';
                    break;
                case 3:
                    $f->level = 'Third Floor';
                    break;
                case 4:
                    $f->level = 'Fourth Floor';
                    break;
                case 5:
                    $f->level = 'Fifth Floor';
                    break;
                case -3:
                    $f->level = 'Underground 2';
                    break;
                case -2:
                    $f->level = 'Underground 1';
                    break;
                case -1:
                    $f->level = 'Basement';
                    break;
                case 0:
                    $f->level = 'Level 0';
                    break;
            }
        }
        return $floor;
    }

    public function updatedSelectedQuartier($quartier_id)
    {
        $this->selectedParkzone = -9;
        if (auth()->user()->id == 1) {
            $this->parkzones = Parkzone::where('status', 1)
                ->where('quartier_id', $quartier_id)
                ->with('quartier')
                ->with('tariff')
                ->get();
            return;
        }
        $this->parkzones = Parkzone::where('status', 1)
            ->whereHas('agent_inparkzone', function ($query) {
                $query->where('agent_id', auth()->user()->id);
            })
            ->where('quartier_id', $quartier_id)
            ->with('quartier')
            ->with('tariff')
            ->get();
        $this->parkzone = $this->parkzones[0];
    }

    public function getNumberOfSlots($parkzone_id, $parkzone_type, $category_id, $side = null, $floor_id = null)
    {
        if ($parkzone_type == 'standard') {
            $slots = CategoryWiseParkzoneSlot::where('parkzone_id', $parkzone_id)
                ->where('category_id', $category_id)
                ->get();
            $available = 0;
            $unavailable = 0;
            foreach ($slots as $slot) {
                // dd($slot->active_parking);  
                if ($slot->active_parking == null) {
                    $available++;
                } else {
                    $unavailable++;
                }
            }
            $totalSlots = $available + $unavailable;
            return ['totalSlots' => $totalSlots, 'available' => $available, 'unavailable' => $unavailable];
        } elseif ($parkzone_type == 'side') {
            $slots = Sides::where('parkzone_id', $parkzone_id)
                ->where('side', $side)
                ->first();
            if ($slots == null) {
                return ['totalSlots' => 0, 'available' => 0, 'unavailable' => 0];
            }
            $totalSlots = $slots->side_slots($category_id)->get();
            $available = 0;
            $unavailable = 0;
            foreach ($totalSlots as $slot) {
                // dd($slot, $slot->active_parking);
                if ($slot->active_parking == null) {
                    $available++;
                } else {
                    $unavailable++;
                }
            }
            return ['totalSlots' => count($totalSlots), 'available' => $available, 'unavailable' => $unavailable];
        } else {
            $slots = FloorSlot::where('categorie_id', $category_id)
                ->where('floor_id', $floor_id)
                ->get();
            $available = 0;
            $unavailable = 0;
            foreach ($slots as $slot) {
                // dd($slot->active_parking);
                if ($slot->active_parking == null) {
                    $available++;
                } else {
                    $unavailable++;
                }
            }
            return ['totalSlots' => count($slots), 'available' => $available, 'unavailable' => $unavailable];
        }
    }

    public function updatedSelectedParkzone($index)
    {
        if ($index == -1) {
            $this->parkzones = Parkzone::where('status', 1)
                ->where('quartier_id', $this->selectedQuartier)
                ->with('quartier')
                ->with('tariff')
                ->get();
            $this->modeshow = 'all';
            $this->parkzone = null;
            return;
        }
        $parkzone_id = $this->parkzones[$index]->id;
        $type = $this->parkzones[$index]->type;
        $this->parkzone = Parkzone::where('id', $parkzone_id)
            ->with('quartier')
            ->with('tariff.category')
            ->first();
        $this->parkzone->slots = $this->parkzone->slots($type)->get();
        $this->modeshow = 'single';
        $this->parkzone_tariff = $this->parkzone->tariff;
    }


    public function render()
    {
        return view('livewire.parkzone-dashboard', [
            'totalSlots' => $this->totalSlots,
        ]);
    }
}
