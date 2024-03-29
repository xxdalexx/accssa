<div>
    @if(!$registered)
    <p class="text-center">
        Registration for this series must be completed through here and not simracing.gp.<br>
        Registration is currently: {!! $series->registrationStatusHtml() !!}
    </p>
    @endif
    @if($series->registration_open)
        @if(Auth::user()->driver->championshipEligible())
            @if(!$registered)
                @include('livewire.series._register-form')
            @else
                <h4 class="text-primary text-center">You are currently registered in the <strong>{{ $split }}</strong> split
                    with the <strong>{{ $car }}</strong></h4><hr>
                @if(!$series->vehicle_change_locked)
                    @include('livewire.series._change-car-form')
                    @can('manage series')
                        <button wire:click="disableCarChange" class="btn btn-outline-danger btn-block">
                            Disable Vehicle Changes
                        </button>
                    @endcan
                @endif
            @endif
        @else
            <p class="text-danger text-center">You currently do not qualify for registration.</p>
        @endif
    @endif
</div>
