<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Application Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background: #teal;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            background: #f9f9f9;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>Thank You for Your Application!</h2>
        </div>

        <div class="content">
            <p>Dear {{ $applicationData['name'] }},</p>

            <p>Thank you for applying to the <strong>{{ $jobListing->title }}</strong> position in our
                {{ $jobListing->department }} department.</p>

            <p>We have received your application and our HR team will review it shortly. If your qualifications match
                our requirements, we will contact you within 1-2 weeks.</p>

            <p>We appreciate your interest in joining our company!</p>

            <p>Best regards,<br>
                HR Team<br>
                {{ config('app.name') }}</p>
        </div>
    </div>
</body>

</html>