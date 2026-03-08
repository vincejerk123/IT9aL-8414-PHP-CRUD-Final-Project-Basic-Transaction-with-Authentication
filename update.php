<?php
session_start();
require "db.php";

// Only admin can access
if($_SESSION["role"]!="admin"){
    die("Access denied");
}

$id = $_GET["id"];

$stmt = $pdo->prepare("SELECT * FROM transactions WHERE id=?");
$stmt->execute([$id]);
$job = $stmt->fetch();

$error = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $title = $_POST["title"];
    $company = $_POST["company"];
    $salary = $_POST["salary"];

    if(empty($title) || empty($company) || empty($salary)){
        $error = "All fields are required.";
    } else {
        $stmt = $pdo->prepare("UPDATE transactions SET job_title=?, company=?, salary=? WHERE id=?");
        $stmt->execute([$title, $company, $salary, $id]);
        header("Location: read.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Job</title>
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
        width: 400px;
        border-radius: 10px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }

    .form h2{
        text-align: center;
        margin-bottom: 20px;
    }

    .form input[type="text"],
    .form input[type="number"]{
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
    <h2>Update Job</h2>

    <?php if($error != ""): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="title" placeholder="Job Title" value="<?= htmlspecialchars($job["job_title"]) ?>" required>
        <input type="text" name="company" placeholder="Company Name" value="<?= htmlspecialchars($job["company"]) ?>" required>
        <input type="number" name="salary" placeholder="Salary" value="<?= htmlspecialchars($job["salary"]) ?>" min="0" required>
        <button type="submit">Update</button>
    </form>

    <a href="read.php">← Back to Job Listings</a>
</div>

</body>
</html>