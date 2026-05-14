<?php

$id = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';
$contact = (isset($_POST['contact']) && $_POST['contact'] != '') ? $_POST['contact'] : '';
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';
$file = (is_uploaded_file($_FILES['file']['tmp_name'])) ? file_get_contents($_FILES['file']['tmp_name']) : '';
$file_type = (is_uploaded_file($_FILES['file']['tmp_name'])) ? $_FILES['file']['type'] : '';
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';


include "../include/dbconfig.php";
include "../include/question_board.php";

$board = new Question_board($db);


if ($mode == 'input') {

    if (strlen(htmlentities($id)) > 20) {
        die("<script>alert('아이디의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    } else if (strlen(htmlentities($subject)) > 50) {
        die("<script>alert('제목의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    } else if (strlen(htmlentities($content)) > 1000) {
        die("<script>alert('본문의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    } else if (strlen(htmlentities($contact)) > 20) {
        die("<script>alert('연락처의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    } else if (strlen(htmlentities($password)) > 30) {
        die("<script>alert('비밀번호의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    }

    $arr = [
        'id' => $id,
        'subject' => htmlentities($subject),
        'content' => htmlentities($content),
        'contact' => htmlentities($contact),
        'password' => $password,
    ];

    if ($file != '') {
        // echo '파일 존재';
        if ($_FILES['file']['size'] > 2097152) {
            die("<script>alert('파일 크기가 너무 큽니다.');location.href='/question_board_list.php';</script>");
        }
        $arr['file'] = $file;
        $arr['file_type'] = $file_type;
    }

    $board->input($arr);
    die("<script>alert('글 작성이 완료되었습니다.');location.href='/question_board_list.php';</script>");
} else if ($mode == 'edit') {
    if (!$board->checkPassword($idx, $password)) {
        die("<script>alert('글 수정이 정상적으로 처리되지 않았습니다.');location.href='/question_board_list.php';</script>");
    }

    if (strlen(htmlentities($subject)) > 50) {
        die("<script>alert('제목의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    } else if (strlen(htmlentities($content)) > 1000) {
        die("<script>alert('본문의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    } else if (strlen(htmlentities($contact)) > 20) {
        die("<script>alert('연락처의 길이가 너무 깁니다.');location.href='/question_board_list.php';</script>");
    }

    $arr = [
        'idx' => $idx,
        'id' => htmlentities($id),
        'subject' => htmlentities($subject),
        'content' => htmlentities($content),
        'contact' => htmlentities($contact),
    ];

    if ($file != '') {
        // echo '파일 존재';
        if ($_FILES['file']['size'] > 2097152) {
            die("<script>alert('파일 크기가 너무 큽니다.');location.href='/question_board_list.php';</script>");
        }
        $arr['file'] = $file;
        $arr['file_type'] = $file_type;
    }

    $board->edit($arr);
    die("<script>alert('글 수정이 완료되었습니다.');location.href='/question_board_list.php';</script>");

}