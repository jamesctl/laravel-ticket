@include('emails.header_lastest')

<div class="content" style="padding: 20px; line-height: 1.6; color: #333">
    <p><b>{{ trans('general.name') }}</b>: {{ $name ?? 'N/A' }}</p>
    <p><b>{{ trans('general.emailAddress') }}</b>: {{ $email ?? 'N/A' }}</p>
    <p>{{ $content ?? 'N/A'}}</p>
</div>
@include('emails.footer_lastest')
