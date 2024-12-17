import os
from django.conf import settings
from django.http import JsonResponse
from django.core.mail import EmailMessage, get_connection

# Sample Django view
def index(request):

    subject = "Hello from Django SMTP"
    recipient_list = ["ilia.umons@gmail.com"] # you can only send to your own email address because of API limitation,
    # If you want to send to other addresses you can't be on local host. You must deploy and verify your domain name.
    from_email = "onboarding@resend.dev"
    message = "<strong>This is an UMONS Tutorial ! and it works!</strong>"

    with get_connection(
        host=settings.RESEND_SMTP_HOST,
        port=settings.RESEND_SMTP_PORT,
        username=settings.RESEND_SMTP_USERNAME,
        password=settings.RESEND_API_KEY,
        use_tls=True,
        ) as connection:
            r = EmailMessage(
                  subject=subject,
                  body=message,
                  to=recipient_list,
                  from_email=from_email,
                  connection=connection).send()
    return JsonResponse({"status": "ok"})
