<?php
session_start();
$id = $_SESSION['id'];


$js_array = ['']; // js 파일 삽입용 문자열 배열

$current_tab = 'mypage';

include "include/header.php";
?>


<main class="w-100 mx-auto border rounded-2 p-5">
    <div>
        <h1>마이페이지 접근용 비밀번호</h1>
        <form action="mypage.php" method="POST">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호를 입력하세요" required
                value="">
            <input type="submit" class="btn btn-primary mt-2" value="확인">
        </form>

    </div>
</main>



<?php
include "include/footer.php";
?>