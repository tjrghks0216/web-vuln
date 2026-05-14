<?php
session_start();
if (isset($_SESSION['id']) == '') {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}

include "include/dbconfig.php";
include "include/free_board.php";

$user_id = (isset($_SESSION['id']) && $_SESSION['id'] != '') ? $_SESSION['id'] : '';
$idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : '';

$board = new Free_board($db);
$board->like($idx, $user_id);
echo "<script>history.go(-1);</script>";