<?php
session_start();

if(!isset($_SESSION["user_id"])){
header("Location: login.php");
exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<style>

body{
font-family:Arial;
background:#f4f6f9;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.box{
background:white;
padding:40px;
border-radius:10px;
box-shadow:0 8px 20px rgba(0,0,0,0.15);
text-align:center;
}

a{
display:block;
margin:10px;
padding:10px;
background:#007ef5;
color:white;
text-decoration:none;
border-radius:5px;
}

</style>

</head>

<body>

<div class="box">

<h2>Welcome <?php echo $_SESSION["name"]; ?></h2>

<?php if($_SESSION["role"]=="admin"){ ?>

<a href="create.php">Create Job</a>

<?php } ?>

<a href="read.php">View Jobs</a>

<a href="logout.php">Logout</a>

</div>

</body>
</html>