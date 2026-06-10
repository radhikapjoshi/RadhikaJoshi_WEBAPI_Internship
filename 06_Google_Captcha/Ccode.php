<?php
// 1. SERVER-SIDE CAPTCHA & LOGIN VALIDATION
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Check if the reCAPTCHA checkbox was clicked
    if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        $message = "Please complete reCAPTCHA.";
    } else {
        $captcha = $_POST['g-recaptcha-response'];
        // Your Google reCAPTCHA Secret Key
        $secretKey = "6LeoGhMtAAAAAOln-Y9lHE7KqRu4_wqyMbVnHzsW";

        // Verify the captcha token with Google's API
        $verifyURL = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha;
        $response = @file_get_contents($verifyURL);
        $responseData = json_decode($response);

        if ($responseData && $responseData->success) {
            // Dummy Credentials Verification
            if ($username == "admin" && $password == "123456") {
                $message = "<span style='color: #2e7d32;'>Login Successful</span>";
            } else {
                $message = "Invalid Username or Password";
            }
        } else {
            $message = "reCAPTCHA Verification Failed. Try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form with reCAPTCHA</title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: Arial, sans-serif;
        }

        body{
            height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg, #ffeef2 0%, #ffd6e0 100%);
            flex-direction: column;
        }

        .login-box{
            width:350px;
            background:#fff;
            padding:30px;
            border-radius:12px;
            box-shadow: 0 8px 24px rgba(255, 182, 193, 0.4);
        }

        .login-box h2{
            text-align:center;
            margin-bottom:20px;
            color: #d81b60;
        }

        .form-group{
            margin-bottom:15px;
        }

        .form-group input{
            width:100%;
            padding:12px;
            border:1px solid #ffccd5;
            border-radius:6px;
            outline: none;
            transition: border-color 0.3s;
        }

        .form-group input:focus{
            border-color: #ff85a2;
        }

        button{
            width:100%;
            padding:12px;
            background:#ff85a2;
            color:#fff;
            border:none;
            border-radius:6px;
            cursor:pointer;
            font-size:16px;
            font-weight: bold;
            transition: background 0.3s;
        }

        button:hover{
            background:#f56384;
        }

        .msg{
            text-align:center;
            margin-top:15px;
            color:#c2185b;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-box">

    <h2>Login</h2>

    <form action="" method="post">

        <div class="form-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="form-group">
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="form-group">
            <div class="g-recaptcha" data-sitekey="6LeoGhMtAAAAAPF8fSywiaDDrs-evEZZ7P6lg1hW"></div>
        </div>

        <button type="submit">Login</button>

    </form>

    <?php if (!empty($message)): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

</div>

</body>
</html>