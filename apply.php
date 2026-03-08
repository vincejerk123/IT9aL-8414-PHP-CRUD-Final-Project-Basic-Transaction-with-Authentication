<?php
session_start();
require "db.php";

$user = $_SESSION["user_id"];
$job = $_GET["id"];

// Prevent duplicate applications
$stmt = $pdo->prepare("SELECT * FROM applications WHERE user_id=? AND job_id=?");
$stmt->execute([$user, $job]);

if($stmt->rowCount() == 0){
    $insert = $pdo->prepare("INSERT INTO applications(user_id,job_id) VALUES(?,?)");
    $insert->execute([$user, $job]);
}

header("Location: read.php");
exit;