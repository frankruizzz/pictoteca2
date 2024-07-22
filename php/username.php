<?php
session_start();

$r = array('username' => '');

if (isset($_SESSION['username'])) {
    $r['username'] = $_SESSION['username'];
}

header('Content-Type: application/json');
echo json_encode($r);
?>
