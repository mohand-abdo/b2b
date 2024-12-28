<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تأكيد التسجيل</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #007bff;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .email-body {
            padding: 20px;
            line-height: 1.6;
            color: #333333;
        }
        .email-body h1 {
            margin-top: 0;
            color: #007bff;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-footer {
            text-align: center;
            padding: 10px;
            background-color: #f4f4f4;
            font-size: 0.9em;
            color: #555555;
        }
        .email-footer a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>
<body dir="rtl">
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>مرحبًا بك في موقعنا!</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <h1>تم تسجيلك بنجاح</h1>
            <p>عزيزي/عزيزتي <strong>{{ $user->name }}</strong>،</p>
            <p>شكرًا لانضمامك إلى موقعنا. نحن سعداء بانضمامك إلى عائلتنا.</p>
            <p>تفاصيل حسابك:</p>
            <ul>
                <li><strong>اسم المستخدم:</strong> {{ $user->name }}</li>
                <li><strong>البريد الإلكتروني:</strong> {{ $user->email }}</li>
                <li><strong>رقم الهاتف:</strong> {{ $user->phone_number }}</li>
                <li><strong>تاريخ التسجيل:</strong> {{ now()->format('Y-m-d') }}</li>
            </ul>
            <p>يمكنك تسجيل الدخول إلى حسابك باستخدام البريد الإلكتروني او رقم التلفون وكلمة المرور التي قمت بتعيينها أثناء التسجيل.</p>
            <p>إذا كانت لديك أي استفسارات، لا تتردد في التواصل معنا.</p>
            <p>مع أطيب التحيات،<br>فريق الدعم</p>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة. <a href="{{ url('/') }}">زيارة موقعنا</a></p>
        </div>
    </div>
</body>
</html>
