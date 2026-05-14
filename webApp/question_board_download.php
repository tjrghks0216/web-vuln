<?php
session_start();

$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';

include "include/dbconfig.php";
include "include/question_board.php";

$board = new question_board($db);
if (!$board->checkPassword($idx, $password)) {
    die("<script>alert('비밀번호가 틀렸습니다.');location.href='question_board_list.php';</script>");
}

$board->download($idx);