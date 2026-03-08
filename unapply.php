<?php
session_start();
require "db.php";

$user = $_SESSION["user_id"];
$job = $_GET["id"];

// Delete the application
$stmt = $pdo->prepare("DELETE FROM applications WHERE user_id=? AND job_id=?");
$stmt->execute([$user, $job]);

header("Location: read.php");
exit;