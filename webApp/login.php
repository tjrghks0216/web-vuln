<?php
#ini_set('session.cookie_httponly', 1);
session_start();
session_regenerate_id();

if (isset($_POST['id']) && $_POST['id'] != '' && isset($_POST['pw']) && $_POST['pw'] != '') {
    include "include/dbconfig.php";
    include "include/member.php";
    $mem = new Member($db);
    $id = $_POST['id'];
    $pw = $_POST['pw'];
    if ($mem->login($id, $pw)) {
        $_SESSION['id'] = $id;
        echo "<script>alert('로그인에 성공했습니다.');</script>";
        echo "<script>window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('등록되지 않은 사용자입니다.');</script>";
    }
}
$current_tab = 'login';
$js_array = []; // js 파일 삽입용 문자열 배열
include "include/header.php";
?>


<main class="mx-auto border rounded-3 p-5" style="height: calc(100vh - 243px)">
    <form action="" method="POST" class="w-25 mt-5 m-auto">
        <h1 class="h3 mb-3">로그인</h1>
        <div class="form-floating mt-2">
            <input type="text" class="form-control" id="id" autocomplete="off" name="id">
            <label for="f_id">아이디</label>
        </div>
        <div class="form-floating mt-2">
            <input type="password" class="form-control" id="pw" autocomplete="off" name="pw">
            <label for="f_pw">비밀번호</label>
        </div>
        <button class="w-100 mt-2 btn btn-lg btn-primary" type="submit" id="btn_login">로그인</button>
    </form>
</main>

<?php
include "include/footer.php";