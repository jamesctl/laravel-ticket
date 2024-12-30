@include('emails.header_lastest')

<div class="content">
    <p>Hi <strong>{{ $name ?? 'N/A'}}</strong>,</p>
    <p>{{__('ticket.email_customer_welcome_onboard')}}:</p>
        <h3>{{__('ticket.email_account_info')}}</h3>
    <p><strong>{{__('ticket.email_address')}}:</strong> {{ $email ?? 'N/A'}}</p>
    <p><strong>{{__('ticket.email_password')}}:</strong> {{ $password ?? 'N/A'}}</p>
</div>
@include('emails.footer_lastest')
