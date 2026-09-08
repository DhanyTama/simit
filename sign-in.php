<?php
session_start();
// Jika sudah login, langsung redirect ke admin/index.php
if (isset($_SESSION['username'])) {
    header('location:admin/index.php');
    exit;
}

$error_msg = "";
if (isset($_GET['error'])) {
    $err = $_GET['error'];
    if ($err == '1') {
        $error_msg = "Username dan Password wajib diisi!";
    } elseif ($err == '2') {
        $error_msg = "Username wajib diisi!";
    } elseif ($err == '3') {
        $error_msg = "Password wajib diisi!";
    } elseif ($err == '4') {
        $error_msg = "Username atau Password salah! Periksa kembali.";
    }
} elseif (isset($_GET['error1'])) {
    $error_msg = "Username dan Password wajib diisi!";
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Login Administrator | SI MRT - IT RS Anwar Medika</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts & Material Icons -->
    <link href="css/opensans.css" rel="stylesheet" type="text/css">
    <link href="css/openfamily.css" rel="stylesheet" type="text/css">
    
    <script>
        // Sync theme cookie so redirect to admin is instantly dark
        (function() {
            var t = localStorage.getItem('simit_theme');
            if (t) {
                document.cookie = "simit_theme=" + encodeURIComponent(t) + "; path=/; max-age=31536000; SameSite=Lax";
            }
        })();
    </script>

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Custom Modern Login Styling -->
    <style>
        * {
            box-sizing: border-box;
        }
        body.login-page {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            min-height: 100vh !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            background: radial-gradient(circle at 10% 15%, rgba(2, 132, 199, 0.22) 0%, transparent 45%),
                        radial-gradient(circle at 90% 85%, rgba(244, 67, 54, 0.18) 0%, transparent 45%),
                        radial-gradient(circle at 50% 50%, rgba(30, 41, 59, 0.5) 0%, transparent 60%),
                        linear-gradient(135deg, #0f172a 0%, #1e293b 60%, #0f172a 100%) !important;
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif !important;
            position: relative !important;
            overflow-x: hidden !important;
            overflow-y: auto !important;
        }

        /* Ambient Glowing Background Blobs */
        .bg-ambient-glow {
            position: fixed;
            border-radius: 50%;
            filter: blur(100px);
            pointer-events: none;
            z-index: 0;
            opacity: 0.7;
        }
        .glow-1 {
            width: 480px;
            height: 480px;
            top: -120px;
            left: -120px;
            background: rgba(2, 132, 199, 0.25);
            animation: floatGlow1 12s ease-in-out infinite alternate;
        }
        .glow-2 {
            width: 520px;
            height: 520px;
            bottom: -150px;
            right: -120px;
            background: rgba(244, 67, 54, 0.22);
            animation: floatGlow2 14s ease-in-out infinite alternate;
        }
        @keyframes floatGlow1 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(50px, 40px) scale(1.1); }
        }
        @keyframes floatGlow2 {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(-40px, -50px) scale(1.15); }
        }

        /* Container */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
            padding: 30px 20px;
            margin: auto;
            animation: cardEntrance 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        @keyframes cardEntrance {
            from {
                opacity: 0;
                transform: translateY(25px) scale(0.98);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Header / Brand */
        .login-header {
            margin-bottom: 24px;
            text-align: center;
        }
        .brand-icon-wrapper {
            width: 62px;
            height: 62px;
            margin: 0 auto 14px auto;
            border-radius: 18px;
            background: linear-gradient(135deg, #f44336 0%, #d32f2f 100%);
            box-shadow: 0 10px 25px rgba(244, 67, 54, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease;
        }
        .brand-icon-wrapper:hover {
            transform: scale(1.05) rotate(3deg);
        }
        .brand-icon-wrapper i {
            color: #ffffff;
            font-size: 32px;
        }
        .brand-title {
            font-size: 26px;
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 6px 0;
            letter-spacing: 0.5px;
            line-height: 1.2;
        }
        .brand-accent {
            color: #f44336;
            font-weight: 800;
            text-shadow: 0 2px 10px rgba(244, 67, 54, 0.4);
        }
        .brand-subtitle {
            color: #94a3b8;
            font-size: 12.5px;
            margin: 0 0 10px 0;
            line-height: 1.4;
            font-weight: 400;
        }
        .hospital-tag {
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.14);
            color: #cbd5e1;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            padding: 4px 14px;
            border-radius: 20px;
            text-transform: uppercase;
        }

        /* Card */
        .login-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 34px 30px 28px 30px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.1);
        }

        .card-heading {
            text-align: center;
            margin-bottom: 22px;
        }
        .card-heading h3 {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 6px 0;
        }
        .card-heading p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        /* Error Alert */
        .alert-custom-error {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #b91c1c;
            padding: 12px 14px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: shakeAlert 0.4s ease-in-out;
        }
        @keyframes shakeAlert {
            0%, 100% { transform: translateX(0); }
            20%, 60% { transform: translateX(-6px); }
            40%, 80% { transform: translateX(6px); }
        }
        .alert-custom-error i {
            font-size: 20px;
            flex-shrink: 0;
        }

        /* Form Controls */
        .form-group-custom {
            margin-bottom: 18px;
            text-align: left;
        }
        .form-label-custom {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }
        .input-container-custom {
            position: relative;
            display: flex;
            align-items: center;
        }
        .input-icon-left {
            position: absolute;
            left: 14px;
            color: #94a3b8;
            font-size: 20px;
            pointer-events: none;
            transition: color 0.2s ease;
        }
        .form-control-custom {
            width: 100%;
            height: 46px;
            padding: 10px 42px 10px 44px;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            font-size: 14px;
            color: #1e293b;
            background-color: #f8fafc;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
        }
        .form-control-custom:focus {
            background-color: #ffffff;
            border-color: #f44336;
            box-shadow: 0 0 0 4px rgba(244, 67, 54, 0.12);
            outline: none;
        }
        .form-control-custom:focus + .input-icon-left,
        .input-container-custom:focus-within .input-icon-left {
            color: #f44336;
        }
        .form-control-custom::placeholder {
            color: #94a3b8;
            opacity: 1;
        }

        /* Toggle Password Button */
        .btn-toggle-pwd {
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 6px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.2s ease, background-color 0.2s ease;
        }
        .btn-toggle-pwd:hover {
            color: #334155;
            background-color: #e2e8f0;
        }
        .btn-toggle-pwd i {
            font-size: 20px;
        }

        /* Submit Button */
        .btn-login-submit {
            width: 100%;
            height: 48px;
            margin-top: 10px;
            background: linear-gradient(135deg, #f44336 0%, #e53935 100%);
            color: #ffffff;
            font-size: 14.5px;
            font-weight: 700;
            letter-spacing: 0.8px;
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(244, 67, 54, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .btn-login-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(244, 67, 54, 0.45);
            background: linear-gradient(135deg, #e53935 0%, #d32f2f 100%);
            color: #ffffff;
        }
        .btn-login-submit:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(244, 67, 54, 0.3);
        }
        .btn-login-submit i {
            font-size: 19px;
            transition: transform 0.2s ease;
        }
        .btn-login-submit:hover i {
            transform: translateX(3px);
        }

        /* Back to Home Link */
        .action-footer {
            margin-top: 22px;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            text-align: center;
        }
        .btn-back-home {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none !important;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .btn-back-home:hover {
            color: #0284c7;
            background-color: #f0f7ff;
        }
        .btn-back-home i {
            font-size: 18px;
        }

        /* Copyright Text */
        .system-copyright {
            margin-top: 20px;
            text-align: center;
            color: #64748b;
            font-size: 12px;
        }
    </style>
</head>

<body class="login-page">
    <!-- Ambient Background Glows -->
    <div class="bg-ambient-glow glow-1"></div>
    <div class="bg-ambient-glow glow-2"></div>

    <div class="login-wrapper">
        <!-- Brand Header -->
        <div class="login-header">
            <div class="brand-icon-wrapper">
                <i class="material-icons">devices</i>
            </div>
            <h1 class="brand-title">SI MRT - <span class="brand-accent">IT</span></h1>
            <p class="brand-subtitle">System Information Maintenance Request And Trouble IT</p>
            <div class="hospital-tag">
                <i class="material-icons" style="font-size: 13px; vertical-align: middle; margin-right: 4px;">local_hospital</i>
                RS ANWAR MEDIKA
            </div>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <div class="card-heading">
                <h3>Login Administrator</h3>
                <p>Silakan masukkan akun Anda untuk melanjutkan</p>
            </div>

            <?php if (!empty($error_msg)): ?>
            <div class="alert-custom-error">
                <i class="material-icons">error_outline</i>
                <span><?php echo htmlspecialchars($error_msg); ?></span>
            </div>
            <?php endif; ?>

            <form id="sign_in" method="POST" action="proseslogin.php">
                <!-- Username -->
                <div class="form-group-custom">
                    <label for="username" class="form-label-custom">Username</label>
                    <div class="input-container-custom">
                        <i class="material-icons input-icon-left">account_circle</i>
                        <input
                            type="text"
                            class="form-control-custom"
                            id="username"
                            name="username"
                            placeholder="Masukkan username"
                            required
                            autofocus
                            autocomplete="username">
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group-custom">
                    <label for="password" class="form-label-custom">Password</label>
                    <div class="input-container-custom">
                        <i class="material-icons input-icon-left">lock</i>
                        <input
                            type="password"
                            class="form-control-custom"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            required
                            autocomplete="current-password">
                        <button type="button" class="btn-toggle-pwd" id="togglePassword" title="Lihat password" tabindex="-1">
                            <i class="material-icons" id="toggleIcon">visibility_off</i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button class="btn-login-submit waves-effect" type="submit" id="btnSubmit">
                    <span>MASUK KE SISTEM</span>
                    <i class="material-icons">arrow_forward</i>
                </button>
            </form>

            <!-- Back to Home Button -->
            <div class="action-footer">
                <a href="index.php" class="btn-back-home">
                    <i class="material-icons">home</i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </div>

        <!-- System Footer -->
        <div class="system-copyright">
            © <?php echo date('Y'); ?> Tim IT RS Anwar Medika. All rights reserved.
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <script>
        // Toggle Password Visibility
        document.addEventListener('DOMContentLoaded', function () {
            var toggleBtn = document.getElementById('togglePassword');
            var pwdInput = document.getElementById('password');
            var toggleIcon = document.getElementById('toggleIcon');

            if (toggleBtn && pwdInput && toggleIcon) {
                toggleBtn.addEventListener('click', function () {
                    if (pwdInput.type === 'password') {
                        pwdInput.type = 'text';
                        toggleIcon.textContent = 'visibility';
                        this.setAttribute('title', 'Sembunyikan password');
                    } else {
                        pwdInput.type = 'password';
                        toggleIcon.textContent = 'visibility_off';
                        this.setAttribute('title', 'Lihat password');
                    }
                    pwdInput.focus();
                });
            }
        });
    </script>
</body>

</html>