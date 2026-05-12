<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 40px;
            border: 1px solid #f0f0f0;
            border-radius: 24px;
            background-color: #fff;
            box-shadow: 0 10px 40px rgba(0,0,0,0.03);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #752738;
            font-size: 24px;
            font-weight: 800;
        }
        .content {
            margin-bottom: 30px;
        }
        .reason-box {
            background-color: #fff5f5;
            padding: 20px;
            border-radius: 16px;
            margin: 20px 0;
            border-left: 4px solid #f87171;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ID Request Update</h1>
        </div>
        <div class="content">
            <p>Hello Brahman student,</p>
            <p>We are writing to inform you that your student ID scheduling request has been <strong>Rejected/Cancelled</strong> by the administration.</p>
            
            <div class="reason-box">
                <p><strong>Reason for Cancellation:</strong></p>
                <p style="font-weight: 500; color: #b91c1c;">
                    {{ $reason }}
                </p>
            </div>
            
            <p>Please review the reason above and make the necessary corrections. You may resubmit your application once the issues have been addressed.</p>
            <p>If you have any questions, please visit the student services office.</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 Brahmmart. Empowering Brahman Excellence.</p>
        </div>
    </div>
</body>
</html>
