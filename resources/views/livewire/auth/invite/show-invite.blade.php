<div class="iq-card-body">
    <form wire:submit.prevent='register'>
        <div class="form-group">
            <label for="email">Email</label>
            <input wire:model="email" type="text" class="form-control">
            @error('email')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>
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

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
