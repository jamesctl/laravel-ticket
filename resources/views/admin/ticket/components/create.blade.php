@php
    // use App\Enums\Ticket as eTicket;
    use Illuminate\Support\Carbon;
@endphp

<td class="col-md-8">{{ Carbon::parse($item->created_at)->format('y-m-d') }}</td>
