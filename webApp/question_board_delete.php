<?php
session_start();
// if (!isset($_SESSION['id']) || $_SESSION['id'] == '' && ($_SESSION['id'] != 'admin')) {
//     die("<script>alert('권한이 없습니다.');location.href='question_board_list.php'</script>");
// }

if (!isset($_POST['idx']) || $_POST['idx'] == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='question_board_list.php'</script>");
}
if (!isset($_POST['password']) || $_POST['password'] == '') {
    die("<script>alert('비밀번호가 빠졌습니다.');location.href='question_board_list.php';</script>");
}

$idx = $_POST['idx'];
$password = $_POST['password'];

include "include/dbconfig.php";
include "include/question_board.php";

$board = new question_board($db);
if (!$board->checkPassword($idx, $password)) {
    die("<script>alert('비밀번호가 틀렸습니다.');location.href='question_board_list.php';</script>");

}


$board->delete($idx);
die("<script>alert('게시물이 삭제되었습니다.');location.href='question_board_list.php'</script>");