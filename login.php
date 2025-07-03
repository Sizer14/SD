<?php
include 'db.php';

$sql = "SELECT * FROM news ORDER BY date_published DESC";
$result = $conn->query($sql);
?>
<html>
<head>
    <title>Login & Registration</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f4f4f4, #eaeaea);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            max-width: 420px;
            width: 100%;
            transition: all 0.3s ease;
        }

        h2 {
            text-align: center;
            color: #d40000;
            margin-bottom: 25px;
        }

        .input-container {
            margin-bottom: 15px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #444;
        }

        input {
            width: 100%;
            padding: 12px;
            font-size: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: border-color 0.3s;
        }

        input:focus {
            border-color: #007BFF;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #d40000;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #b30000;
        }

        .switch-link {
            text-align: center;
            margin-top: 15px;
        }

        .switch-link a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        .switch-link a:hover {
            text-decoration: underline;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>

    <!-- Login Form -->
    <div id="login-form" class="container form-section active">
        <h2>Login</h2>
        <form action="submit_form.php" method="post">
            <div class="input-container">
                <label for="login-username">Username:</label>
                <input type="text" id="login-username" name="username" required>
            </div>
            <div class="input-container">
                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <div class="switch-link">
                <p>New to Varendra Alo? <a href="#" onclick="switchForm('register')">Create an account</a></p>
            </div>
        </form>
    </div>

    <!-- Registration Form -->
    <div id="register-form" class="container form-section">
        <h2>Register</h2>
        <form action="submit_form.php" method="post">
            <div class="input-container">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="input-container">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-container">
                <label for="register-username">Username:</label>
                <input type="text" id="register-username" name="username" required>
            </div>
            <div class="input-container">
                <label for="register-password">Password:</label>
                <input type="password" id="register-password" name="password" required>
            </div>
            <button type="submit">Register</button>
            <div class="switch-link">
                <p>Already a Member? <a href="#" onclick="switchForm('login')">Login here</a></p>
            </div>
        </form>
    </div>

    <script>
        function switchForm(formType) {
            // Hide both forms
            document.getElementById('login-form').classList.remove('active');
            document.getElementById('register-form').classList.remove('active');
            
            // Show the selected form
            if (formType === 'login') {
                document.getElementById('login-form').classList.add('active');
            } else if (formType === 'register') {
                document.getElementById('register-form').classList.add('active');
            }
        }
    </script>
</body>
</html>
<?php
