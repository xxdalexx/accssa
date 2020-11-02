<div>
    <div class="form-group">
        <label for="email">Series Name</label>
        <input wire:model="tokenString" type="text" class="form-control">
    </div>
    <button wire:click="$set('tokenString', '')" class="btn btn-warning">Clear</button>
    <button wire:click="saveToken" class="btn btn-primary">Save</button>
    @if($this->success)
        Saved.
    @endif
</div>
