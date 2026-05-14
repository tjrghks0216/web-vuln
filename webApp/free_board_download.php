<?php
session_start();
if (isset($_SESSION['id']) == '') {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}
$idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : '';

if (!isset($_GET['token_download']) || $_GET['token_download'] == '' || $_SESSION['token_download'] != $_GET['token_download'] || !isset($_GET['token_download'])) {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}

include "include/dbconfig.php";
include "include/free_board.php";

$board = new Free_board($db);
$board->download($idx);