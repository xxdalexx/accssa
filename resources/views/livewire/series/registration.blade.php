<div>
    <p class="text-center">
        Registration for this series must be completed through here and not simracing.gp.<br>
        Registration is currently: {!! $series->registrationStatusHtml() !!}
    </p>
    @if($series->registration_open)
        @if(Auth::user()->driver->championshipEligible())
            @if(!$registered)
                <div class="form-group">
                    <label>Register With Vehicle:</label>
                    <select wire:model="carInput" class="form-control">
                        @foreach($this->cars as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <button wire:click="register" class="btn btn-outline-success btn-block">Register For Series</button>
                    <span wire:loading wire:target="register" class="text-success">Working...</span>
                </div>
            @else
                <p class="text-primary text-center">You are currently registered in the {{ $split }} split.</p>
            @endif
        @else
            <p class="text-danger text-center">You currently do not qualify for registration.</p>
        @endif
    @endif
</div>
