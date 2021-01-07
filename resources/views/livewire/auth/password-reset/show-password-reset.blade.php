<div class="iq-card-body">
    <form wire:submit.prevent="resetPassword">
        <div class="form-group">
            <label for="email">Password</label>
            <input wire:model="password" type="password" class="form-control">
            @error('password')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Reenter Password</label>
            <input wire:model="passwordVerify" type="password" class="form-control">
            @error('passwordVerify')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="btn btn-outline-success btn-block">Reset</button>
    </form>
</div>
