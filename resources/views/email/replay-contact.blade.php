<x-mail::message>
# Hello {{ $clientName }},

Thank you for reaching out to us. We appreciate your message and value your time.

**Our Response:**
{{ $replyMessage }}

If you have any further questions, feel free to reply to this email.

<x-mail::button :url="config('app.url')">
Visit Our Website
</x-mail::button>

Best regards,
**{{ config('app.name') }}**
{{ config('app.url') }}

</x-mail::message>