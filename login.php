<?php
session_start();
require 'koneksi.php';

$error = '';


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $koneksi->query("SELECT * FROM users WHERE username='$username'");
    $data = $query->fetch_assoc();

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'superadmin') {
            header("Location: SUPER/super_desktop.php");
        } elseif ($data['role'] == 'admin') {
            header("Location: ADMIN/admin_desktop.php");
        } elseif ($data['role'] == 'guest') {
            header("Location: GUEST/guest_desktop.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Fixsy Preventive Maintenance</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body, html {
            height: 100%;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .left {
            flex: 1;
            background: linear-gradient(135deg, #a8e063, #56ab2f);
            color: white;
            padding: 80px 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left h1 {
            font-size: 2.8em;
            margin-bottom: 20px;
        }

        .left p {
            font-size: 1.1em;
            max-width: 400px;
        }

        .right {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
        }

        .right h2 {
            color: #56ab2f;
            margin-bottom: 20px;
        }

        form {
            width: 100%;
            max-width: 320px;
        }

        .subtitle {
            font-size: 18px;
            font-weight: bold;
            color: #444;
            margin-bottom: 5px;
            text-align: center;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group img {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
        }

        .input-group input {
            width: 100%;
            padding: 12px 20px 12px 45px;
            border: none;
            border-radius: 25px;
            background-color: #f2f2f2;
            box-sizing: border-box;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9em;
            color: #888;
            margin-bottom: 20px;
        }

        .actions a {
            text-decoration: none;
            color: #56ab2f;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #56ab2f);
            border: none;
            color: white;
            font-weight: bold;
            border-radius: 25px;
            cursor: pointer;
            font-size: 1em;
            transition: 0.3s;
        }

        button:hover {
            opacity: 0.9;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }

        .logo-top-left {
            position: absolute;
            top: 20px;
            left: 20px;
            width: 80px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left">
            <h1>Welcome to Fixsy</h1>
            <p>Reliable preventive maintenance for your IT assets. Proactive care starts here.</p>
        </div>
        <div class="right">
            <form method="post">
                <div class="subtitle">Preventive Maintenance</div>
                <h2 style="text-align: center;" >USER LOGIN</h2>
                <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
                <div class="input-group">
                    <img src="https://cdn-icons-png.flaticon.com/512/747/747376.png" alt="user">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="input-group">
                    <img src="https://cdn-icons-png.flaticon.com/512/3064/3064155.png" alt="password">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="actions">
                    <label><input type="checkbox"> Remember</label>
                    <a href="#">Forgot password?</a>
                </div>
                <button type="submit" name="login">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>