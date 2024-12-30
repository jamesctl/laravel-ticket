@include('emails.header_lastest')

<div class="content" style="padding: 20px; line-height: 1.6; color: #333">
    <h2>{{ trans('ticket.email_have_a_new_message') }}</h2>
    <p><strong>{{ trans('ticket.email_full_name') }}:</strong> {{ $data['name'] ?? 'N/A'}}</p>
    <p><strong>{{ trans('ticket.email_address') }}:</strong> {{ $data['email'] ?? 'N/A'}}</p>
    <p><strong>{{ trans('ticket.lb_ticket_title') }}:</strong> {{ $data['title'] ?? 'N/A'}}</p>
    <p><strong>{{ trans('ticket.comment') }}:</strong> {{ $data['comment'] ?? 'N/A'}}</p>
</div>
@include('emails.footer_lastest')
