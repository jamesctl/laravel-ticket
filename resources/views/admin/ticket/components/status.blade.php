@php
    use App\Enums\Ticket as eTicket;
@endphp

<td>
    <span class="badge 
        @if ($item->status === eTicket::IS_PROCESSING) badge-light-success 
        @elseif ($item->status === eTicket::IS_COMPLETE) badge-light-info
        @elseif ($item->status === eTicket::IS_NEW) badge-light-warning

        @else badge-light-danger @endif">
        {{ $item->status }}
    </span>
</td>
