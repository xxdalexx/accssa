<div>
    <div class="form-group">
        <label>Message To Send</label>
        <input wire:model.lazy="messageString" type="text" class="form-control">
    </div>
    <button wire:click="sendMessage" class="btn btn-primary">Send</button>
    <p wire:loading wire:target="sendMessage" class="text-success">Sending Message. Don't leave the page until this disappears.</p>
    @if($this->success)
        <p class="text-success">Sent.</p>
    @endif
</div>
