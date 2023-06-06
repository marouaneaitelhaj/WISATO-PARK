<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Parkzone;
use App\Models\Category;
use App\Models\Quartier;
use App\Models\CategoryWiseParkzoneSlot;

class ParkzoneDashboard extends Component
{
    public $quartiers;
    public $categories;
    public $parkzones = [];
    public $selectedQuartier = null;
    public $totalSlots = 0;

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
    }

    public function updatedSelectedQuartier($quartier_id)
    {
        if (auth()->user()->id == 1) {
            $this->parkzones = Parkzone::where('status', 1)
                ->where('quartier_id', $quartier_id)
                ->with('quartier')
                ->with(['slots' => function ($query) {
                    $query->with('category');
                }])
                ->get();
            return;
        }
        $this->parkzones = Parkzone::where('status', 1)
            ->whereHas('agent_inparkzone', function ($query) {
                $query->where('agent_id', auth()->user()->id);
            })
            ->where('quartier_id', $quartier_id)
            ->with('quartier')
            ->with(['slots' => function ($query) {
                $query->with('category');
            }])
            ->get();
    }

    public function getNumberOfSlots($parkzone_id, $category_id)
    {
        $slots = CategoryWiseParkzoneSlot::where('parkzone_id', $parkzone_id)
            ->where('category_id', $category_id)
            ->get();
        $available = 0;
        $unavailable = 0;
        foreach ($slots as $slot) {
            if ($slot->active_parking == null) {
                $available++;
            } else {
                $unavailable++;
            }
        }
        $totalSlots = $available + $unavailable;
        return ['totalSlots' => $totalSlots, 'available' => $available, 'unavailable' => $unavailable];
    }


    public function render()
    {
        return view('livewire.parkzone-dashboard', [
            'totalSlots' => $this->totalSlots,
        ]);
    }
}
