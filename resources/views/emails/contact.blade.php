<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .header {
            background-color: #48D1CC;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }

        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .footer {
            background-color: #696969;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 0 0 5px 5px;
        }

        .field {
            margin-bottom: 15px;
        }

        .field strong {
            display: inline-block;
            width: 120px;
            color: #48D1CC;
        }

        .message-box {
            background-color: white;
            padding: 15px;
            border-left: 4px solid #48D1CC;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Pesan Kontak Baru</h2>
        <p>Kategori: {{ $contactData['subject'] }}</p>
    </div>

    <div class="content">
        <div class="field">
            <strong>Nama:</strong> {{ $contactData['name'] }}
        </div>

        <div class="field">
            <strong>Email:</strong> {{ $contactData['email'] }}
        </div>

        <div class="field">
            <strong>Kategori:</strong> {{ $contactData['subject'] }}
        </div>

        <div class="field">
            <strong>Pesan:</strong>
            <div class="message-box">
                {!! nl2br(e($contactData['message'])) !!}
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Email ini dikirim otomatis dari form kontak website.</p>
        <p>Waktu: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>

</html>