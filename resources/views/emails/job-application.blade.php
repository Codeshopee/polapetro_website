<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New Job Application</title>
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

        .field {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #555;
        }

        .value {
            margin-top: 5px;
        }

        .cover-letter {
            background: white;
            padding: 15px;
            border-left: 4px solid #teal;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>New Job Application Received</h2>
        </div>

        <div class="content">
            <h3>Position: {{ $jobListing->title }}</h3>
            <p><strong>Department:</strong> {{ $jobListing->department }}</p>

            <hr>

            <div class="field">
                <div class="label">Applicant Name:</div>
                <div class="value">{{ $applicationData['name'] }}</div>
            </div>

            <div class="field">
                <div class="label">Email:</div>
                <div class="value">{{ $applicationData['email'] }}</div>
            </div>

            <div class="field">
                <div class="label">Phone:</div>
                <div class="value">+62{{ $applicationData['phone'] }}</div>
            </div>

            <div class="field">
                <div class="label">Date of Birth:</div>
                <div class="value">{{ \Carbon\Carbon::parse($applicationData['date_of_birth'])->format('d F Y') }}</div>
            </div>

            <div class="field">
                <div class="label">Job Category:</div>
                <div class="value">{{ $applicationData['job_category'] }}</div>
            </div>

            @if($applicationData['cover_letter'])
                <div class="field">
                    <div class="label">Cover Letter:</div>
                    <div class="cover-letter">
                        {!! nl2br(e($applicationData['cover_letter'])) !!}
                    </div>
                </div>
            @endif

            <hr>

            <p><strong>Note:</strong> Resume attachment is included with this email.</p>

            <p style="margin-top: 30px; font-size: 12px; color: #666;">
                This application was submitted on {{ now()->format('d F Y \a\t H:i') }}
            </p>
        </div>
    </div>
</body>

</html>