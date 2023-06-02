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
    public function mount()
    {
        // $this->quartiers = Quartier::all();
        // select all quartiers that has parkzones and has agent_inparkzone
        $this->quartiers = Quartier::whereHas('parkzones', function ($query) {
            $query->where('status', 1)
                ->whereHas('agent_inparkzone', function ($query) {
                    $query->where('agent_id', auth()->user()->id);
                });
        })->get();
        $this->categories = Category::all();
    }
    public function updatedSelectedQuartier($quartier_id)
    {
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
        echo count($slots);
    }
    public function disponible($parkzone_id, $category_id){
        // return two things: number of available slots and number of unavailable slots
        $slots = CategoryWiseParkzoneSlot::where('parkzone_id', $parkzone_id)
            ->where('category_id', $category_id)
            ->with('active_parking')
            ->get();
        $available = 0;
        $unavailable = 0;
        foreach($slots as $slot){
            if($slot->active_parking == null){
                $available++;
            }else{
                $unavailable++;
            }
        }
        $html = '<p class="text-success">Available: '.$available.'</p><p class="text-danger">Unavailable: '.$unavailable.'</p>';
        $this->dispatchBrowserEvent('show-sweet-alert', [
            'type' => 'success',
            'message' => $html
        ]);
    }
    public function render()
    {
        return view('livewire.parkzone-dashboard');
    }
}
