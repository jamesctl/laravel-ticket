@include('emails.header')

<div class="row-pad-bot-0" style="padding-bottom:0 !important;padding-left: 16px;padding-right: 16px;padding-top: 0">
  <p class="body  body-lg body-lg-important body-link-rausch light text-left   " style='padding:0;margin:0;font-family:"Cereal", "Helvetica", Helvetica, Arial, sans-serif;font-weight:300;color:#484848;hyphens:none;-moz-hyphens:none;-webkit-hyphens:none;-ms-hyphens:none;font-size:18px;line-height:1.4;text-align:left;margin-bottom:0px !important;'>
    {{trans('general.helloMail')}}</p>
</div>
</div>
<div>
<div class="" style="padding-bottom:24px">
</div>
</div>
<div>
<div class="row-pad-bot-0" style="padding-bottom:0 !important;padding-left: 16px;padding-right: 16px;padding-top: 0">
  <p class="body  body-lg body-lg-important body-link-rausch light text-left   " style='padding:0;margin:0;font-family:"Cereal", "Helvetica", Helvetica, Arial, sans-serif;font-weight:300;color:#484848;hyphens:none;-moz-hyphens:none;-webkit-hyphens:none;-ms-hyphens:none;font-size:18px;line-height:1.4;text-align:left;margin-bottom:0px !important;'>
    {{trans('email.testEmailSystemSuccess')}}
  </p>       
</div>
</div>
<div>
<div class="" style="padding-bottom:24px">
</div>
</div>
<div>

@include('emails.footer')
