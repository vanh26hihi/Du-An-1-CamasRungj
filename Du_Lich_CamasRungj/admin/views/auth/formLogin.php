﻿<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng Nhập - Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="./assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="./assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./assets/dist/css/adminlte.min.css">
    
    <style>
        body.login-page {
            background: #f4f6f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-box {
            width: 420px;
        }
        
        .login-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        
        .login-card .card-header {
            background: #5a8dee;
            border: none;
            padding: 30px 20px;
        }
        
        .login-card .card-header h1 {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }
        
        .login-card .card-body {
            padding: 35px 30px;
            background: white;
        }
        
        .login-box-msg {
            font-size: 15px;
            color: #6c757d;
            margin-bottom: 25px;
            text-align: center;
            font-weight: 500;
        }
        
        .input-group {
            margin-bottom: 20px;
        }
        
        .input-group .form-control {
            height: 45px;
            border: 2px solid #e9ecef;
            border-right: none;
            font-size: 14px;
            padding: 10px 15px;
            transition: all 0.3s;
        }
        
        .input-group .form-control:focus {
            border-color: #5a8dee;
            box-shadow: none;
        }
        
        .input-group-text {
            background: white;
            border: 2px solid #e9ecef;
            border-left: none;
            padding: 10px 15px;
        }
        
        .input-group .form-control:focus ~ .input-group-append .input-group-text {
            border-color: #5a8dee;
        }
        
        .btn-login {
            height: 45px;
            font-size: 15px;
            font-weight: 600;
            background: #5a8dee;
            border: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .btn-login:hover {
            background: #4879dc;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(90, 141, 238, 0.3);
        }
        
        .icheck-primary label {
            font-size: 14px;
            color: #6c757d;
            font-weight: 500;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }
        
        .forgot-password a {
            color: #5a8dee;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .forgot-password a:hover {
            color: #4879dc;
            text-decoration: underline;
        }
        
        .alert {
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="card login-card">
            <div class="card-header text-center">
                <h1><i class="fas fa-user-shield"></i> Admin Panel</h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>

                <?php if (isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <i class="icon fas fa-ban"></i> <?= $_SESSION['error'] ?>
                    </div>
                    <?php unset($_SESSION['error']); ?>
                <?php endif; ?>

                <form action="<?= BASE_URL_ADMIN . '?act=check-login-admin' ?>" method="post" id="loginForm" novalidate>
                    <div class="input-group">
                        <input type="email" 
                               name="email" 
                               id="email"
                               class="form-control" 
                               value="<?= htmlspecialchars($_SESSION['old_email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                               placeholder="Nhập địa chỉ email"
                               maxlength="255"
                               autocomplete="email"
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="invalid-feedback d-block" id="emailError" style="margin-top: -15px; margin-bottom: 10px; font-size: 13px;"></div>
                    
                    <div class="input-group">
                        <input type="password" 
                               name="password" 
                               id="password"
                               class="form-control" 
                               placeholder="Nhập mật khẩu"
                               minlength="6"
                               maxlength="255"
                               autocomplete="current-password"
                               required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="invalid-feedback d-block" id="passwordError" style="margin-top: -15px; margin-bottom: 10px; font-size: 13px;"></div>
                    
                    <div class="row align-items-center mb-3">
                        <div class="col-7">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                        </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-primary btn-block btn-login" id="btnLogin">
                                <span class="btn-text">Đăng Nhập</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="forgot-password">
                    <a href="#">
                        <i class="fas fa-question-circle"></i> Quên mật khẩu?
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="./assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="./assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="./assets/dist/js/adminlte.min.js"></script>
    
    <script>
    $(document).ready(function() {
        const form = $('#loginForm');
        const emailInput = $('#email');
        const passwordInput = $('#password');
        const btnLogin = $('#btnLogin');
        
        // Clear old email from session after displaying
        <?php if (isset($_SESSION['old_email'])) unset($_SESSION['old_email']); ?>
        
        // Email validation
        emailInput.on('blur', function() {
            validateEmail();
        });
        
        // Password validation
        passwordInput.on('blur', function() {
            validatePassword();
        });
        
        // Clear error on input
        emailInput.on('input', function() {
            $('#emailError').text('');
            $(this).removeClass('is-invalid');
        });
        
        passwordInput.on('input', function() {
            $('#passwordError').text('');
            $(this).removeClass('is-invalid');
        });
        
        // Form submission
        form.on('submit', function(e) {
            e.preventDefault();
            
            const emailValid = validateEmail();
            const passwordValid = validatePassword();
            
            if (emailValid && passwordValid) {
                // Show loading state
                btnLogin.prop('disabled', true);
                btnLogin.find('.btn-text').text('Đang xử lý...');
                btnLogin.find('.spinner-border').removeClass('d-none');
                
                // Submit form
                this.submit();
            }
        });
        
        function validateEmail() {
            const email = emailInput.val().trim();
            const emailError = $('#emailError');
            
            if (email === '') {
                emailError.text('Vui lòng nhập địa chỉ email');
                emailInput.addClass('is-invalid');
                return false;
            }
            
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                emailError.text('Địa chỉ email không hợp lệ');
                emailInput.addClass('is-invalid');
                return false;
            }
            
            if (email.length > 255) {
                emailError.text('Email quá dài (tối đa 255 ký tự)');
                emailInput.addClass('is-invalid');
                return false;
            }
            
            emailError.text('');
            emailInput.removeClass('is-invalid');
            return true;
        }
        
        function validatePassword() {
            const password = passwordInput.val();
            const passwordError = $('#passwordError');
            
            if (password === '') {
                passwordError.text('Vui lòng nhập mật khẩu');
                passwordInput.addClass('is-invalid');
                return false;
            }
            
            if (password.length < 6) {
                passwordError.text('Mật khẩu phải có ít nhất 6 ký tự');
                passwordInput.addClass('is-invalid');
                return false;
            }
            
            if (password.length > 255) {
                passwordError.text('Mật khẩu quá dài');
                passwordInput.addClass('is-invalid');
                return false;
            }
            
            passwordError.text('');
            passwordInput.removeClass('is-invalid');
            return true;
        }
    });
    </script>
</body>

</html>