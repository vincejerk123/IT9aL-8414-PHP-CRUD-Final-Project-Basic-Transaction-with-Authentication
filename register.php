<?php
require "db.php";

$error="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

$name=$_POST["name"];
$email=$_POST["email"];
$password=$_POST["password"];

if(empty($name) || empty($email) || empty($password)){
$error="All fields required.";
}else{

$hash=password_hash($password,PASSWORD_DEFAULT);

$stmt=$pdo->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
$stmt->execute([$name,$email,$hash]);

header("Location: login.php");
exit;

}

}
?>

<!DOCTYPE html>
<html>
<head>
<title>Register</title>

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
    background:white;
    padding:30px;
    width:350px;
    border-radius:10px;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
}

.form h2{
    text-align:center;
    margin-bottom:20px;
}

.form input{
    width:92%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
}

.form button{
    width:50%;
    padding:10px;
    background:#007ef5;
    color:white;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;
    display:block;
    margin:20px auto 0 auto;
}

.form button:hover{
    background:#013d75;
}

.form a{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#007ef5;
}

.form a:hover{
    text-decoration:underline;
}

.error{
    background-color:#f8d7da;
    color:#721c24;
    padding:10px;
    border-radius:5px;
    margin-bottom:15px;
    text-align:center;
    font-size:14px;
}
</style>

</head>
<body>

<div class="form">

<h2>Register</h2>

<?php if($error!=""){ ?>
<div class="error"><?php echo $error; ?></div>
<?php } ?>

<form method="POST">

<input type="text" name="name" placeholder="Name" required>

<input type="email" name="email" placeholder="Email" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Register</button>

</form>

<a href="login.php">Back</a>

</div>

</body>
</html>