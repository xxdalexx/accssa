<div>
    <div class="iq-card-body">
    @if($apiFailed)
        <p class="text-danger">Connection to SGP failed. Check token.</p>
    @else
        <form wire:submit.prevent="getInfo">
            <div class="row">
                <div class="col-md-6">
                    <label>SGP Event ID</label>
                    <input wire:model.lazy="sgpEventId" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                    <label>Practice Server Title - (Leave blank to auto generate from event name.)</label>
                    <input wire:model.lazy="serverNameInput" type="text" class="form-control">
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Practice Server Type</label>
                <select wire:model="type" class="form-control mb-3">
                    <option value="quali">Fixed Quali - Generates an Optimal Track</option>
                    <option value="full">Direct Copy - All sessions from Event</option>
                </select>
            </div>

            <button type="submit" class="btn btn-block btn-outline-success mt-2">Generate</button>
        </form>
        <p wire:loading wire:target="getInfo">Generating</p>
        @if($notACC)
            <p class="text-danger">This currently only supports config files for ACC.</p>
        @endif
    @endif
    <hr>
    <h5>settings.json</h5>
    <p>
        If you are listed as an admin for the SGP community hosting the event, the passwords will populate the same as the event.
    </p>
    <textarea wire:model="settings" class="form-control" style="height: 30em; width: 100%; line-height: 1.5;"></textarea>

    <hr>
    <h5>event.json</h5>
    <p>
        Track, Ambient Temp, Cloud Level, Rain, and Weather Randomness are populated from SGP Event, and
        the hour of day is set from the first race.
    </p>
    <textarea wire:model="event" class="form-control" style="height: 32em; width: 100%; line-height: 1.5;"></textarea>

    <hr>
    <h5>assistRules.json</h5>
    <p>
        All are populated from SGP Event.
    </p>
    <textarea wire:model="assistRules" class="form-control" style="height: 18em; width: 100%; line-height: 1.5;"></textarea>

    <hr>
    <h5>eventRules.json</h5>
    <p>These are defaults and are not currently affected by the SGP Event.</p>
    <textarea wire:model="eventRules" class="form-control" style="height: 22em; width: 100%; line-height: 1.5;"></textarea>

</div>
