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
        .info-box {
            background-color: #fafafa;
            padding: 20px;
            border-radius: 16px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #752738;
            color: #fff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ID Request Approved</h1>
        </div>
        <div class="content">
            <p>Hello Brahman student,</p>
            <p>Great news! Your student ID request has been approved and processed. You can now pick up your physical ID at the student services office.</p>
            
            <div class="info-box">
                <p><strong>Scheduled Pickup Date:</strong></p>
                <p style="font-size: 18px; color: #28a745; font-weight: 700;">
                    {{ date('F d, Y - h:i A', strtotime($scheduling->pick_up_date)) }}
                </p>
            </div>
            
            <p>Please bring any proof of registration or a temporary ID when you visit the office. If you cannot make it on the scheduled date, please contact the student panel.</p>
        </div>
        <div class="footer">
            <p>&copy; 2026 Brahmmart. Empowering Brahman Excellence.</p>
        </div>
    </div>
</body>
</html>
