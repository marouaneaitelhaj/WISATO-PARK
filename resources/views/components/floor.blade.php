<div>
    @foreach($this->getfloors($parkzone->id) as $floor)
    <h1>{{$floor->level}}</h1>
    <div class="d-flex flex-wrap bg-white py-5 justify-content-around w-100 mt-5 rounded">
        @foreach ($categories as $categorie)
        <div class="text-center d-flex flex-column" style="cursor: pointer;">
            @if ($categorie->type == 'Electric Car')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-car mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>
            @elseif($categorie->type == 'Electric Bike')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-bicycle  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>

            @elseif($categorie->type == 'Electric Bus')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-bus  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>
            @elseif($categorie->type == 'Electric Truck')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-truck  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>
            @elseif($categorie->type == 'Gasoline Car')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-car  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>

            @elseif($categorie->type == 'Gasoline Bike')

            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-bicycle  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>


            @elseif($categorie->type == 'Gasoline Bus')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-bus  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>

            @elseif($categorie->type == 'Gasoline Truck')
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-truck  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, null, $floor->id)['available'] }}</span>

            @endif
        </div>
        @endforeach
    </div>
    @endforeach
</div>