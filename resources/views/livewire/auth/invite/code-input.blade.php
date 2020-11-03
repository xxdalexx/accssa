<div class="iq-card-body">
    <form wire:submit.prevent='checkCode'>
        <div class="form-group">
            <label for="email">Invite Code</label>
            <input wire:model="inviteCode" type="text" class="form-control">
        </div>

        @if($this->failed)
            <p class="text-danger">Invalid Invite Code</p>
        @endif

        <button type="submit" class="btn btn-primary">Continue</button>
    </form>
</div>
