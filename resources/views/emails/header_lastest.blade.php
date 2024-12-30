<!DOCTYPE html>
 <html lang="en">
   <head>
     <meta charset="UTF-8" />
     <meta name="viewport" content="width=device-width, initial-scale=1.0" />
     <link
       href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
       rel="stylesheet"
     />
     <title>Email Template</title>
   </head>
   <body
     style="
       font-family: Arial, sans-serif;
       background-color: #f4f4f4;
       margin: 0;
       padding: 0;
     "
   >
     <div
       style="
         max-width: 600px;
         width: 100%;
         margin: 20px auto;
         background-color: #ffffff;
         border-radius: 8px;
         overflow: hidden;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
       "
     >
       <!-- Header -->
       <table width="100%" cellpadding="0" cellspacing="0" border="0">
         <tr
           style="
             background: url({{asset('assets')}}/ticket/email/main-banner.png);
             display: flex;
             flex-wrap: wrap;
             justify-content: space-between;
             align-items: center;
             padding: 20px;
             border-radius: 10px;
             gap: 10px;
             background-size: cover;
           "
         >
           <!-- header left -->
           <td style="flex: 1; padding: 20px">
             <img src="{{asset('assets')}}/ticket/email/Group.png" alt="logo" width="218px" />
             <p
               style="
                 font-size: 12px;
                 font-weight: 300;
                 color: #d0d0d0;
                 margin-top: 10px;
                 line-height: 15px;
               "
             >
               Our team of talented developers select the most capable framework
               to save time
             </p>
           </td>
           <!-- header right -->
           <td
             style="
               width: 219px;
               background-image: url('{{asset('assets')}}/ticket/email/Video-Player.png');
               background-size: cover;
               background-position: center;
               border-radius: 10px;
               border: 2px solid #ffffff;
               height: 113px;
               display: flex;
               justify-content: end;
               align-items: center;
             "
           >
             <img src="{{asset('assets')}}/ticket/email/phone.png" alt="" />
           </td>
         </tr>
       </table>
