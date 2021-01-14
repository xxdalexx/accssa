<div class="form-group">
    <label>Change Registered Vehicle:</label>
    <select wire:model="carInput" class="form-control">
        @foreach($this->cars as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>
    <button wire:click="changeCar" class="btn btn-outline-success btn-block">Change Registered Vehicle</button>
    <span wire:loading wire:target="changeCar" class="text-success">Working...</span>
</div>
