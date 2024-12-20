{{-- <!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة بريد إلكتروني</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* التصميم الر��يسي لصفحة البريد ال��لكتروني */
        /* إعدادات عامة */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #e9f1fa;
            /* لون الخلفية كما في الصورة */
            color: #333;
        }

        /* الهيدر */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo .icon {
            font-size: 24px;
            font-weight: bold;
            color: #82b366;
            /* لون الأيقونة */
            margin-right: 10px;
        }

        .company-name {
            font-size: 20px;
            color: #333;
        }

        nav ul {
            display: flex;
            list-style: none;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
            transition: color 0.3s;
        }

        nav ul li a:hover {
            color: #82b366;
        }

        .btn-primary {
            background-color: rgb(118, 91, 233);
            border-width: 0px;
            border-style: solid;
            border-color: rgb(118, 91, 233);
            border-radius: 30px;
            color: rgb(255, 255, 255);
            direction: ltr;
            font-family: inherit;
            font-weight: 700;
            line-height: 2;
            max-width: 100%;
            padding: 5px 30px;
            width: auto;
            display: inline-block;
            text-align: center;
            letter-spacing: normal;
            text-decoration: none;
            margin-top: 5px;
        }

        /* المحتوى الرئيسي */
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 80px);
            /* لتوسيط المحتوى */
            padding: 20px;
        }

        .content {
            display: flex;
            align-items: center;
        }

        .content img {
            max-width: 300px;
            margin-right: 20px;
        }

        .details h2 {
            font-size: 28px;
            margin-bottom: 10px;
            color: #333;
        }

        .details p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>

<body>
    <!-- الهيدر -->
    <header>
        <div class="logo">
            <span class="icon">b2b travel</span>
        </div>
    </header>

    <!-- القسم الرئيسي -->
    <section class="main-content">
        <div class="content">
            <img src="agent.jpeg" alt="illustration">
            <div class="details">
                <h2>اضافة حاج او معتمر</h2>
                <p>لقد قام الوكيل {{ $agent_name }}  باضافة {{ $client->type == 'حاج' ? 'حاج' : 'معتمر' }} بالاسم {{ $client->tree4_name }}</p>
                <a href="#" class="btn btn-primary">تاكيد</a>
            </div>
        </div>
    </section>
</body>

</html> --}}


{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Notification</title>
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
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 0;
            border-radius: 8px 8px 0 0;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .content {
            padding: 20px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #666666;
            padding: 10px 0;
            border-top: 1px solid #dddddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>إشعار جديد</h1>
        </div>
        <div class="content">
             <p>عزيزي {{ $admain->name }}،</p> 
            <p>عزيزي الادمن،</p>
            <p>
                الوكيل <strong>{{ $agent_name }}</strong> قد قام بإدخال <strong>{{ $client->type == 'حاج' ? 'حاج' : 'معتمر' }} {{ $client->tree4_name }}</strong>.
            </p>
            <p>يرجى التحقق من التفاصيل واتخاذ الإجراءات اللازمة.</p>
        </div>
        <div class="footer">
            &copy; 2024 نظام الإشعارات
        </div>
    </div>
</body>
</html> --}}

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إشعار جديد</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            direction: rtl;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            text-align: center;
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: #ffffff;
            padding: 20px 0;
            border-radius: 8px 8px 0 0;
            animation: slideDown 1.5s ease;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
        }

        .content {
            padding: 20px;
            animation: fadeIn 2s ease;
        }

        .content p {
            font-size: 18px;
            line-height: 1.8;
            color: #333333;
            margin: 10px 0;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #666666;
            padding: 10px 0;
            border-top: 1px solid #dddddd;
            margin-top: 20px;
            animation: slideUp 1.5s ease;
        }

        /* Animations */
        @keyframes slideDown {
            0% {
                transform: translateY(-100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            0% {
                transform: translateY(100%);
                opacity: 0;
            }
            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .email-container {
                padding: 10px;
            }

            .content p {
                font-size: 16px;
            }

            .header h1 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .header h1 {
                font-size: 20px;
            }

            .content p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>إشعار جديد</h1>
        </div>
        <div class="content">
            <p>عزيزي الأدمن،</p>
            <p>
                الوكيل <strong>مهند</strong> قد قام بإدخال <strong>حاج محمد</strong>.
            </p>
            <p>يرجى التحقق من التفاصيل واتخاذ الإجراءات اللازمة.</p>
        </div>
        <div class="footer">
            &copy; 2024 نظام الإشعارات
        </div>
    </div>
</body>
</html>

