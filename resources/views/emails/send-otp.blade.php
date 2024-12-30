@include('emails.header_lastest')

<div class="content" style="padding: 20px; line-height: 1.6; color: #333">
    <p>Here is your OTP code for verification:</p>
    <h3>Your OTP Code:</h3>
    <p><strong>{{ $otp ?? 'N/A'}}</strong></p>
    <p>Please use this OTP to complete your action.</p>
</div>
@include('emails.footer_lastest')