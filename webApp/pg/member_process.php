<?php
session_start();
include "../include/dbconfig.php";
include "../include/member.php"; // Member class 정의

$mem = new Member($db);

// 모드 체크
$mode = (isset($_POST['mode']) && $_POST['mode'] != '') ? $_POST['mode'] : '';

$id = (isset($_POST['id']) && $_POST['id'] != '') ? $_POST['id'] : '';
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';
$email = (isset($_POST['email']) && $_POST['email'] != '') ? $_POST['email'] : '';
$addr1 = (isset($_POST['addr1']) && $_POST['addr1'] != '') ? $_POST['addr1'] : '';
$addr2 = (isset($_POST['addr2']) && $_POST['addr2'] != '') ? $_POST['addr2'] : '';
$password_before = (isset($_POST['password_before']) && $_POST['password_before'] != '') ? $_POST['password_before'] : '';

// 특수문자 체크
function specialChars($str)
{
    return preg_match('/[^a-zA-Z0-9]/', $str) > 0;
}


// 아이디 중복확인
if ($mode == 'id_chk') {

    if ($id == '') {
        die(json_encode(['result' => 'empty_id']));
    }

    if (specialChars($id)) {
        die(json_encode(['result' => 'special_char']));
    }

    if ($mem->id_exist(htmlentities($id))) {

        die(json_encode(['result' => 'fail']));

    } else {
        die(json_encode(['result' => 'success']));

    }

} else if ($mode == 'input') {

    if (strlen(htmlentities($id)) > 20) {
        die("<script>alert('아이디의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($email)) > 30) {
        die("<script>alert('이메일의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($addr1)) > 50) {
        die("<script>alert('주소의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($addr2)) > 50) {
        die("<script>alert('상세주소의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($password)) > 30) {
        die("<script>alert('비밀번호의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    }
    $arr = [
        'id' => htmlentities($id),
        'password' => $password,
        'email' => htmlentities($email),
        'addr1' => htmlentities($addr1),
        'addr2' => htmlentities($addr2),
    ];

    $mem->input($arr);

    echo "<script>self.location.href='../login.php'</script>";

} else if ($mode == "edit") {

    if (strlen(htmlentities($email)) > 30) {
        die("<script>alert('이메일의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($addr1)) > 50) {
        die("<script>alert('주소의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($addr2)) > 50) {
        die("<script>alert('상세주소의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    } else if (strlen(htmlentities($password)) > 30) {
        die("<script>alert('비밀번호의 길이가 너무 깁니다.');location.href='/index.php';</script>");
    }
    $arr = [
        'id' => $_SESSION['id'],
        'password' => $password,
        'email' => htmlentities($email),
        'addr1' => htmlentities($addr1),
        'addr2' => htmlentities($addr2),
        'password_before' => $password_before,
    ];


    if (!$mem->edit($arr)) {
        die("<script>alert('수정에 실패했습니다.');
    self.location.href='../index.php'</script>");
    }

    echo "<script>
    alert('수정되었습니다.');
    self.location.href='../logout.php'</script>";
}