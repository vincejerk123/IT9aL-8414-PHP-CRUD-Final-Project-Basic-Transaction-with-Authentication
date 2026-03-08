<?php
session_start();
require "db.php";

$error = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if($user && password_verify($password,$user["password"])){

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["name"] = $user["name"];
        $_SESSION["role"] = $user["role"];

        // Redirect based on role
        if($user["role"] == "admin"){
            header("Location: read.php");  // admin sees full CRUD
        } else {
            header("Location: read.php");  // user sees apply-only
        }
        exit;

    } else {
        $error = "Invalid login.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
    body{
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .form{
        background: white;
        padding: 30px;
        width: 350px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .form h2{
        text-align: center;
        margin-bottom: 20px;
    }

    .form input[type="email"],
    .form input[type="password"]{
        width: 92%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form button{
        width: 50%;
        padding: 10px;
        background-color: #007ef5;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        display: block;
        margin: 20px auto 0 auto;
    }

    .form button:hover{
        background-color: #013d75;
    }

    .form a{
        display: block;
        text-align: center;
        margin-top: 15px;
        text-decoration: none;
        color: #007ef5;
    }

    .form a:hover{
        text-decoration: underline;
    }

    .error{
        background-color: #f8d7da;
        color: #721c24;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 15px;
        text-align: center;
        font-size: 14px;
    }
    </style>
</head>
<body>

<div class="form">
    <h2>Login</h2>

    <?php if($error != ""): ?>
    <div class="error"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>

    <a href="register.php">Register</a>
</div>

</body>
</html>