<div class="form-group">
    <label>Register With Vehicle: </label>
    <select wire:model="carInput" class="form-control">
        @foreach($this->cars as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>
    <button wire:click="register" class="btn btn-outline-success btn-block">Register For Series</button>
    <span wire:loading wire:target="register" class="text-success">Working...</span>
</div>
