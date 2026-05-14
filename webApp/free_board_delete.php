<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['id'] == '' && ($_SESSION['id'] != 'admin')) {
    die("<script>alert('권한이 없습니다.');location.href='free_board_list.php'</script>");
}

if (!isset($_GET['idx']) || $_GET['idx'] == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='free_board_list.php'</script>");
}

if (!isset($_GET['token']) || $_GET['token'] == '' || $_SESSION['token'] != $_GET['token']) {
    die("<script>alert('권한이 없습니다.');location.href='free_board_list.php'</script>");
}

$id = $_SESSION['id'];
$idx = $_GET['idx'];

include "include/dbconfig.php";
include "include/free_board.php";

$board = new Free_board($db);
$result = $board->find_writer($idx);
if ($id != $result['id'] && $id != 'admin') {
    die("<script>alert('권한이 없습니다.');location.href='free_board_list.php'</script>");
}

$board->delete($idx);
die("<script>alert('게시물이 삭제되었습니다.');location.href='free_board_list.php'</script>");