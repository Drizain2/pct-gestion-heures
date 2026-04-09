<!-- resources/views/layouts/guest.blade.php -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UVCI — {{ $title ?? 'Connexion' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Poppins', sans-serif; }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1B5E20 0%, #2E7D32 50%, #E65100 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-logo .logo-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #2E7D32, #4CAF50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 12px;
            font-size: 2rem;
            color: #fff;
        }

        .auth-logo h3 {
            color: #2E7D32;
            font-weight: 700;
            margin: 0;
        }

        .auth-logo p {
            color: #888;
            font-size: 0.85rem;
            margin: 0;
        }

        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1.5px solid #e0e0e0;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: #2E7D32;
            box-shadow: 0 0 0 3px rgba(46,125,50,0.15);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.88rem;
            color: #444;
        }

        .btn-login {
            background: linear-gradient(135deg, #2E7D32, #4CAF50);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            width: 100%;
            color: #fff;
            transition: all 0.3s;
        }

        .btn-login:hover {
            background: linear-gradient(135deg, #E65100, #FF6F00);
            transform: translateY(-1px);
            box-shadow: 0 5px 15px rgba(230,81,0,0.4);
        }

        .divider {
            text-align: center;
            color: #aaa;
            font-size: 0.8rem;
            margin: 15px 0;
            position: relative;
        }

        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 42%;
            height: 1px;
            background: #e0e0e0;
        }

        .divider::before { left: 0; }
        .divider::after  { right: 0; }
    </style>
</head>
<body>
    <div class="auth-card">
        <div class="auth-logo">
            <div class="logo-icon">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h3>UVCI</h3>
            <p>Université Virtuelle de Côte d'Ivoire</p>
        </div>

        {{ $slot }}
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>