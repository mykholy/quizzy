Dear {{ $name }},

We received a request to reset the password for your {{env('APP_NAME')}} Mobile App account. To proceed with the password reset, please use the following verification code:

Verification Code: {{$code}}

Please enter this code in the designated field within the {{env('APP_NAME')}} Mobile App to complete the password reset process. If you did not initiate this request or if you have any concerns regarding the security of your account, please contact our support team immediately at {{env('MAIL_FROM_ADDRESS')}}.

Thank you for using {{env('APP_NAME')}}!

Best regards,

{{env('APP_NAME')}}
