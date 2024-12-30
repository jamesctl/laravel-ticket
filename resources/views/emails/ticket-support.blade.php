{{-- @include('emails.header')

<div style="font-family: Arial, sans-serif; color: #484848; padding: 24px; max-width: 600px; margin: auto; border: 1px solid #dadada; border-radius: 5px;">
    <div style="text-align: center; padding-bottom: 24px;">
        <h2 style="color: #0056b3;">Cảm ơn quý khách đã liên hệ với chúng tôi</h2>
    </div>

    <div style="padding-left: 16px; padding-right: 16px;">
        <table style="width: 100%; border-bottom: 1px solid #dadada; padding-bottom: 8px; margin-bottom: 8px;">
            <tr>
                <td style="font-weight: bold; padding: 8px 0;">Tên khách hàng:</td>
                <td>{{ $name }}</td>
            </tr>
        </table>
    </div>

    <div style="padding-top: 16px;">
        <p>Xin chào {{ $name }},</p>
        <p>Chúng tôi xin chân thành cảm ơn quý khách đã liên hệ với đội ngũ hỗ trợ của chúng tôi. Dưới đây là nội dung phản hồi từ chúng tôi:</p>

        <div style="background-color: #f9f9f9; padding: 16px; border-left: 4px solid #0056b3; margin: 16px 0;">
            {{ $messageContent }}
        </div>

        <p>Chúng tôi hy vọng phản hồi này sẽ giúp ích cho quý khách. Nếu có thêm bất kỳ câu hỏi nào, vui lòng liên hệ lại với chúng tôi.</p>
        <p>Trân trọng,</p>
        <p>Đội ngũ Hỗ trợ Khách hàng</p>
    </div>

    <div style="padding-top: 24px; text-align: center; color: #aaa;">
        <p>Vui lòng không trả lời email này. Mọi thắc mắc, vui lòng liên hệ qua hệ thống hỗ trợ chính thức của chúng tôi.</p>
    </div>
</div>

<div>
    @include('emails.footer')
</div> --}}

@include('emails.header_lastest')

<div class="content" style="padding: 20px; line-height: 1.6; color: #333">
    <h2>{{__('ticket.email_header_thankyou_contact')}}</h2>
    <p><strong>{{__('ticket.email_customer_name')}}</strong>: {{ $name ?? 'N/A'}}</p>
    <p>{{__('ticket.email_ticket_support_content_1')}}:</p>
    <p>{!! $messageContent ?? 'N/A' !!}</p>
    <p> {{__('ticket.email_ticket_support_content_2')}}</p>
    <p>{{__('ticket.email_ticket_support_content_3')}}</p>
    <p>{{__('ticket.email_ticket_support_content_4')}}</p>
</div>

@include('emails.footer_lastest')