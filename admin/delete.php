<?php

require '../config/config.php';

$sql = "DELETE FROM posts WHERE id=".$_GET['id'];
$stmt = $pdo->prepare($sql);
$result = $stmt->execute();

header("Location: index.php");

?>