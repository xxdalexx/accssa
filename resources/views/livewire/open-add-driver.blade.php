<div class="iq-card-body">
    @if($authed)
    <p wire:loading class="text-success text-center">Loading Data</p>

    <div class="form-group">
        <label>League - {{ $leagueId }}</label>
        <select wire:model="leagueId" class="form-control mb-3">
            @foreach($leagueList as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>

    <hr>
    <label>Type</label>
    <select wire:model="type" class="form-control">
        <option value="Event">Event</option>
        <option value="Championship">Championship</option>
    </select>

    @if($type == 'Event')
        <hr>
        <div class="form-group">
            <label>Event - {{ $sgpEventId }}</label>
            <select wire:model="sgpEventId" class="form-control mb-3">
                @foreach($upcomingEvents as $event)
                    <option value="{{ $event['id'] }}">{{ $event['name'] }}</option>
                @endforeach
            </select>
        </div>
    @endif

    @if($type == 'Championship')
        <hr>
        <div class="form-group">
            <label>Championship - {{ $sgpChampionshipId }}</label>
            <select wire:model="sgpChampionshipId" class="form-control mb-3">
                @foreach($upcomingChamps as $champ)
                    <option value="{{ $champ['id'] }}">{{ $champ['name'] }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <hr>
    <div class="form-group">
        <label>Member - {{ $driverId }}</label>
        <select wire:model="driverId" class="form-control mb-3">
            @foreach($memberList as $member)
                <option value="{{ $member['id'] }}">{{ $member['name'] }}</option>
            @endforeach
        </select>
    </div>

    <hr>
    <div class="form-group">
        <label>Car - {{ $carId }}</label>
        <select wire:model="carId" class="form-control mb-3">
            @foreach($carList as $car)
                <option value="{{ $car['id'] }}">{{ $car['name'] }}</option>
            @endforeach
        </select>
    </div>

    @if($hasCarClass)
        <hr>
        <div class="form-group">
            <label>Class - {{ $carClass }}</label>
            <select wire:model="carClass" class="form-control mb-3">
                @foreach($carClassList as $class)
                    <option value="{{ $class['id'] }}">{{ $class['name'] }}</option>
                @endforeach
            </select>
        </div>
    @endif

    <hr>
    <button wire:click="addDriver" class="btn btn-outline-primary btn-block">Add</button>
    <hr>
    <p>If any errors show in this box, let Dale know.</p>
    @dump($addResponse)

    @else
    <form wire:submit.prevent="auth">
        <label>Auth Code</label>
        <input wire:model.lazy="pass" type="text" class="form-control">
        <button type="submit" class="btn btn-block btn-outline-success mt-2">Unlock</button>
    </form>
    @endif
</div>
