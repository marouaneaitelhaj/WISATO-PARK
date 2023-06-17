<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryWiseParkzoneSlotNumber;
class CategoryWiseParkzoneSlotNumberController extends Controller
{
    public function store($parkzone_id, $category_id, $slot_number){
        // store here slot_number category_id slot_number
        $CategoryWiseParkzoneSlotNumber = new CategoryWiseParkzoneSlotNumber();
        $CategoryWiseParkzoneSlotNumber->parkzone_id = $parkzone_id;
        $CategoryWiseParkzoneSlotNumber->category_id = $category_id;
        $CategoryWiseParkzoneSlotNumber->slot_number = $slot_number;
        $CategoryWiseParkzoneSlotNumber->save();
    }
}
