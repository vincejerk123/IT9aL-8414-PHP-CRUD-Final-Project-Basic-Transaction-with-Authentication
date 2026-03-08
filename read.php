<?php
session_start();
require "db.php";

$user_id = $_SESSION["user_id"] ?? 0;

$stmt = $pdo->query("SELECT * FROM transactions ORDER BY id DESC");
$jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch applications for this user
$appStmt = $pdo->prepare("SELECT job_id FROM applications WHERE user_id=?");
$appStmt->execute([$user_id]);
$appliedJobs = $appStmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html>
<head>
<title>Job Listings</title>
<style>
body{
    font-family: Arial, sans-serif;
    background-color:#f4f6f9;
    margin:0;
    padding:40px;
}
.container{
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 8px 20px rgba(0,0,0,0.15);
    max-width:900px;
    margin:auto;
}
h2{text-align:center; margin-bottom:25px;}
.top-bar{display:flex; justify-content:space-between; margin-bottom:20px;}
.btn{ text-decoration:none; padding:8px 15px; border-radius:5px; color:white; font-size:14px;}
.back{background:#6c757d;} .back:hover{background:#545b62;}
.add{background:#007ef5;} .add:hover{background:#013d75;}
table{width:100%; border-collapse:collapse;}
th{background:#007ef5; color:white; padding:12px;}
td{padding:12px; text-align:center; border-bottom:1px solid #ddd;}
tr:hover{background:#f1f1f1;}
.action a, .action button{
    text-decoration:none;
    padding:6px 10px;
    border-radius:4px;
    color:white;
    font-size:13px;
    margin:0 3px;
    cursor:pointer;
    border:none;
}
.edit{background:#28a745;} .edit:hover{background:#1e7e34;}
.delete{background:#dc3545;} .delete:hover{background:#a71d2a;}
.apply{background:#007ef5;} .apply:hover{background:#013d75;}
.apply-disabled{background:#6c757d; pointer-events:none;}
.empty{padding:20px; text-align:center; color:#777;}
</style>
</head>
<body>

<div class="container">
<h2>Job Listings</h2>
<div class="top-bar">
<a href="dashboard.php" class="btn back">← Back</a>
<?php if($_SESSION["role"]=="admin"){ ?>
<a href="create.php" class="btn add">+ Create Job</a>
<?php } ?>
</div>

<table>
<tr>
<th>Title</th>
<th>Company</th>
<th>Salary</th>
<th>Action</th>
</tr>

<?php if(count($jobs) > 0): ?>
    <?php foreach($jobs as $job): ?>
<tr>
<td><?= $job["job_title"] ?></td>
<td><?= $job["company"] ?></td>
<td><?= $job["salary"] ?></td>
<td class="action">
<?php if($_SESSION["role"]=="admin"): ?>
    <a href="update.php?id=<?= $job["id"] ?>" class="edit">Edit</a>
    <a href="delete.php?id=<?= $job["id"] ?>" class="delete" onclick="return confirm('Delete this job?')">Delete</a>
<?php else: ?>
    <?php if(in_array($job["id"], $appliedJobs)): ?>
        <button class="apply apply-disabled">Applied</button>
        <a href="unapply.php?id=<?= $job["id"] ?>" class="delete">Unapply</a>
    <?php else: ?>
        <a href="apply.php?id=<?= $job["id"] ?>" class="apply">Apply</a>
    <?php endif; ?>
<?php endif; ?>
</td>
</tr>
    <?php endforeach; ?>
<?php else: ?>
<tr>
<td colspan="4" class="empty">No jobs available.</td>
</tr>
<?php endif; ?>
</table>
</div>
</body>
</html>