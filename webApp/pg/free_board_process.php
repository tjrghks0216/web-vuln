<?php
session_start();
if (!isset($_SESSION['id'])) {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}
$id = (isset($_SESSION['id']) && $_SESSION['id'] != '') ? $_SESSION['id'] : '';
$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$subject = (isset($_POST['subject']) && $_POST['subject'] != '') ? $_POST['subject'] : '';
$content = (isset($_POST['content']) && $_POST['content'] != '') ? $_POST['content'] : '';
$file = (is_uploaded_file($_FILES['file']['tmp_name'])) ? file_get_contents($_FILES['file']['tmp_name']) : '';
$file_type = (is_uploaded_file($_FILES['file']['tmp_name'])) ? $_FILES['file']['type'] : '';
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';
$token = (isset($_POST['token']) && $_POST['token'] != '') ? $_POST['token'] : '';


include "../include/dbconfig.php";
include "../include/free_board.php";

$board = new Free_board($db);


if ($mode == 'input') {

    if (strlen(htmlentities($subject)) > 50) {
        die("<script>alert('제목의 길이가 너무 깁니다.');location.href='/free_board_list.php';</script>");
    } else if (strlen(htmlentities($content)) > 1000) {
        die("<script>alert('본문의 길이가 너무 깁니다.');location.href='/free_board_list.php';</script>");
    }

    $arr = [
        'id' => $id,
        // 제목 xss 일부러 뚫어둠
        //'subject' => htmlentities($subject), 
        'subject' => $subject,
        // 글내용 xss 일부러 뚫어둠
        //'content' => htmlentities($content)
        'content' => $content
    ];

    if ($file != '') {
        // echo '파일 존재';
        if ($_FILES['file']['size'] > 2097152) { // 2MB
            die("<script>alert('파일 크기가 너무 큽니다.');location.href='/free_board_list.php';</script>");
        }
        $arr['file'] = $file;
        $arr['file_type'] = $file_type;
    }
    $board->input($arr);
    die("<script>alert('글 작성이 완료되었습니다.');location.href='/free_board_list.php';</script>");
} else if ($mode == 'edit') {
    if (!isset($_SESSION['token']) || $token == '' || $token != $_SESSION['token']) {
        die("<script>alert('권한이 없습니다.');history.go(-2);</script>");
    }

    if (strlen(htmlentities($subject)) > 50) {
        die("<script>alert('제목의 길이가 너무 깁니다.');location.href='/free_board_list.php';</script>");
    } else if (strlen(htmlentities($content)) > 1000) {
        die("<script>alert('본문의 길이가 너무 깁니다.');location.href='/free_board_list.php';</script>");
    }

    $arr = [
        'idx' => $idx,
        // 제목 xss 일부러 뚫어둠
        //'subject' => htmlentities($subject), 
        'subject' => $subject,
        // 글내용 xss 일부러 뚫어둠
        //'content' => htmlentities($content)
        'content' => $content
    ];

    if ($file != '') {
        // echo '파일 존재';
        if ($_FILES['file']['size'] > 2097152) {
            die("<script>alert('파일 크기가 너무 큽니다.');location.href='/free_board_list.php';</script>");
        }
        $arr['file'] = $file;
        $arr['file_type'] = $file_type;
    }

    $board->edit($arr);
    die("<script>alert('글 수정이 완료되었습니다.');history.go(-2);</script>");

}