<?php
// delete_user.php
include 'db.php';
session_start();

if (!isset($_GET['id'])) {
    die("User ID not specified.");
}

$id = intval($_GET['id']);
$sql = "DELETE FROM users WHERE id = $id";

if (mysqli_query($conn, $sql)) {
    header("Location: manage_users.php");
    exit();
} else {
    echo "Error deleting user: " . mysqli_error($conn);
}
?>
