<div>
    <div class="form-group">
        <label>Bearer Token</label>
        <input wire:model="tokenString" type="text" class="form-control">
    </div>
    <button wire:click="$set('tokenString', '')" class="btn btn-warning">Clear</button>
    <button wire:click="saveToken" class="btn btn-primary">Save</button>
    @if($this->tokenSuccess)
        Saved.
    @endif
    <hr>
    <div class="form-group">
        <label>League Id</label>
        <input wire:model="leagueIdString" type="text" class="form-control">
    </div>
    <button wire:click="$set('leagueIdString', '')" class="btn btn-warning">Clear</button>
    <button wire:click="saveLeagueId" class="btn btn-primary">Save</button>
    @if($this->leagueIdSuccess)
        Saved.
    @endif
</div>
