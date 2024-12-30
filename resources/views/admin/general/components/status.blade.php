@php
    // use App\Enums\Ticket as eTicket;
@endphp

<td>
    <span class="badge 
        @if ($item->status === 'active') badge-light-success 
        @else badge-light-danger @endif">
        {{ $item->status }}
    </span>
</td>
