<div>
    <div>
        <h3 class="text-center pt-5"> {{ $parkzone->name }}</h3>
        <h6 class="text-center pt-5">Left</h6>

        <div class="d-flex flex-wrap bg-light py-5 justify-content-around w-100 mt-5 border rounded">
            @foreach ($categories as $categorie)
            <div class="text-center d-flex flex-column" style="cursor: pointer;">
                @if ($categorie->type == 'Electric Car')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-car mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>
                @elseif($categorie->type == 'Electric Bike')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-bicycle  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>

                @elseif($categorie->type == 'Electric Bus')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-bus  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>
                @elseif($categorie->type == 'Electric Truck')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-truck  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>
                @elseif($categorie->type == 'Gasoline Car')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-car  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>

                @elseif($categorie->type == 'Gasoline Bike')

                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-bicycle  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>


                @elseif($categorie->type == 'Gasoline Bus')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-bus  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>

                @elseif($categorie->type == 'Gasoline Truck')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-truck  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "left")['available'] }}</span>

                @endif
            </div>
            @endforeach
        </div>
    </div>
    <div>
        <h6 class="text-center pt-5">Right</h6>
        <div class="d-flex flex-wrap bg-light py-5 justify-content-around w-100 mt-5 rounded">
            @foreach ($categories as $categorie)
            <div class="text-center d-flex flex-column" style="cursor: pointer;">
                @if ($categorie->type == 'Electric Car')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-car mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>
                @elseif($categorie->type == 'Electric Bike')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-bicycle  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>

                @elseif($categorie->type == 'Electric Bus')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-bus  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>
                @elseif($categorie->type == 'Electric Truck')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-primary fa-truck  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>
                @elseif($categorie->type == 'Gasoline Car')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-car  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>

                @elseif($categorie->type == 'Gasoline Bike')

                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-bicycle  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>


                @elseif($categorie->type == 'Gasoline Bus')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-bus  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>

                @elseif($categorie->type == 'Gasoline Truck')
                <div class="d-flex justify-content-center align-items-center">
                    <i class="fa fa-2x text-warning fa-truck  mb-3 mx-2"></i>
                    <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['totalSlots'] }}</span>
                </div>
                <span class="mb-2">Available Slots: </span>
                <span class="font-weight-bold fs-5 text-success" style="">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id, "right")['available'] }}</span>

                @endif
            </div>
            @endforeach
        </div>
    </div>
</div>