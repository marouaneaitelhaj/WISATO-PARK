<div class="cabin">
    @foreach($slots->groupBy('parkzone_id') as $florSlots)
    <div class="row">
        <div class="col-12">
            <h4 class="border-top pt-2 text-center">ParkZone : {{ $florSlots->first()->parkzone->name }}</h4>
        </div>
    </div>
    <div class="row row--10 mb-4">
        <div class="seats">
            @foreach ($florSlots as $index => $slot)
            <div class="seat {{ $slot->active_parking != NULL && $slot->active_parking->id != $id ? 'text-white' : '' }}">
                <input type="radio" value="{{ $slot->id }}" required name="slot_id" {{ $slot->active_parking != NULL && $slot->active_parking->id != $id ? 'disabled' : ($slot->active_parking != NULL && $slot->active_parking->id == $id ? 'checked' : '' ) }} id="{{ $slot->slotId }}" />
                <label for="{{ $slot->slotId }}">
                    {{ $slot->slot_name }}<br>
                    @if($slot->active_parking != NULL && $slot->active_parking->id != $id)
                    @if($slot->category->type == 'Electric Car')
                    <i class='fa fa-car text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Electric Bike')
                    <i class='fa fa-motorcycle text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Car')
                    <i class='fa fa-car text-danger' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Electric Truck')
                    <i class='fa fa-truck text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Electric Bus')
                    <i class='fa fa-bus text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Bike')
                    <i class='fa fa-motorcycle text-danger' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Bus')
                    <i class='fa fa-bus text-danger' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Truck')
                    <i class='fa fa-truck text-danger' aria-hidden='true'></i>
                    @endif
                    @else
                    @if($slot->category->type == 'Electric Car')
                    <i class='fa fa-car text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Electric Bike')
                    <i class='fa fa-motorcycle text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Car')
                    <i class='fa fa-car text-danger' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Electric Truck')
                    <i class='fa fa-truck text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Electric Bus')
                    <i class='fa fa-bus text-success' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Bike')
                    <i class='fa fa-motorcycle text-danger' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Bus')
                    <i class='fa fa-bus text-danger' aria-hidden='true'></i>
                    @elseif($slot->category->type == 'Gasoline Truck')
                    <i class='fa fa-truck text-danger' aria-hidden='true'></i>
                    @endif
                    @endif
                </label>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>