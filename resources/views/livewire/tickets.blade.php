<div>
    <ul class="list-group mt-2">
        <li class="list-group-item active">All Ticktes</li>
        @foreach($tickets as $ticket)

        <li class="list-group-item {{$active==$ticket->id ? 'bg-light':''}} " wire:click="$emit('ticketSelected',{{$ticket->id}})">{{$ticket->question}}</li>

        @endforeach
    </ul>
</div>