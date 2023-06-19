<div>
    <h3 class="text-center pt-5"> {{ $parkzone->name }}</h3>
    <div class="d-flex flex-wrap bg-light py-5 justify-content-around w-100 mt-5 border rounded">
        @foreach ($categories as $categorie)
        <div class="checknocontent text-center d-flex flex-column" onclick="showgreenbtn(<?php echo $categorie->id ?>, <?php echo $parkzone->id ?>, 'standard')" style="cursor: pointer;">
            @if ($categorie->type == 'Electric Car' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-car mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>
            @elseif($categorie->type == 'Electric Bike' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-bicycle  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>

            @elseif($categorie->type == 'Electric Bus' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-bus  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>
            @elseif($categorie->type == 'Electric Truck' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-primary fa-truck  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>
            @elseif($categorie->type == 'Gasoline Car' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-car  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>

            @elseif($categorie->type == 'Gasoline Bike' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)

            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-bicycle  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>


            @elseif($categorie->type == 'Gasoline Bus' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0)
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-bus  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>

            @elseif($categorie->type == 'Gasoline Truck' && $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] > 0 )
            <div class="d-flex justify-content-center align-items-center">
                <i class="fa fa-2x text-warning fa-truck  mb-3 mx-2"></i>
                <span class="font-weight-bold fs-4 pb-2">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['totalSlots'] }}</span>
            </div>
            <span class="mb-2">Available Slots: </span>
            <span class="font-weight-bold fs-5 text-success">{{ $this->getNumberOfSlots($parkzone->id,$parkzone->type, $categorie->id)['available'] }}</span>

            @endif
            <script>
            var checknocontent = document.getElementsByClassName("checknocontent");
            for (var i = 0; i < checknocontent.length; i++) {
                if (checknocontent[i].innerText == "") {
                    // delete checknocontent[i] from DOM 
                    checknocontent[i].remove();
                }
            }
        </script>
        </div>
        
        @endforeach
    </div>
</div>
<script>
</script>