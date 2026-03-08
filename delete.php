<?php
require "db.php";

$id=$_GET["id"];

$stmt=$pdo->prepare("DELETE FROM transactions WHERE id=?");
$stmt->execute([$id]);

header("Location: read.php");
exit;