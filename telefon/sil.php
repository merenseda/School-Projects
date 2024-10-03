<?php
include('db.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $db->prepare("DELETE FROM rehber WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: rehber.php');
    exit();
}
?>
