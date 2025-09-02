<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Pola Petro Development</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #f9fafb;
        }

        .header {
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .content {
            padding: 30px 20px;
            background: white;
            margin: 0 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .footer {
            padding: 20px;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .button {
            display: inline-block;
            background: linear-gradient(135deg, #22c55e, #3b82f6);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="logo">Pola Petro Development</div>
            <p>Thank You for Your Interest</p>
        </div>

        <div class="content">
            <h2>Dear {{ $data['name'] }},</h2>

            <p>Thank you for contacting Pola Petro Development. We have received your message regarding
                "<strong>{{ $data['subject'] }}</strong>" and appreciate your interest in our services.</p>

            <p>Our team will review your inquiry and get back to you within 24-48 hours during business days. In the
                meantime, feel free to explore our website to learn more about our comprehensive industrial solutions.
            </p>

            <div style="background: #f3f4f6; padding: 20px; border-radius: 6px; margin: 20px 0;">
                <h3 style="margin-top: 0; color: #374151;">Your Message Summary:</h3>
                <p><strong>Subject:</strong> {{ $data['subject'] }}</p>
                <p><strong>Message:</strong></p>
                <p style="white-space: pre-line; color: #6b7280;">{{ $data['message'] }}</p>
            </div>

            <p>If you have any urgent inquiries, please don't hesitate to contact us directly:</p>
            <ul>
                <li><strong>Phone:</strong> +62 21 XXXX XXXX</li>
                <li><strong>Email:</strong> info@polapetro.co.id</li>
            </ul>

            <a href="{{ url('/') }}" class="button">Visit Our Website</a>

            <p>Best regards,<br>
                <strong>Pola Petro Development Team</strong>
            </p>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Pola Petro Development. All rights reserved.</p>
            <p>This is an automated message. Please do not reply to this email.</p>
        </div>
    </div>
</body>

</html>