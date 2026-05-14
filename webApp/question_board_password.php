<?php
session_start();
$masterPassword = (isset($_SESSION['id']) && $_SESSION['id'] == 'admin') ? 'tjrghks0216' : '';

$idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : '';
$mode = (isset($_GET['mode']) && $_GET['mode'] != '') ? $_GET['mode'] : '';
if (!isset($idx) || $idx == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='index.php'</script>");
}
$js_array = ['']; // js 파일 삽입용 문자열 배열

$current_tab = 'question_board';

include "include/header.php";
?>


<main class="w-100 mx-auto border rounded-2 p-5">
    <div>
        <?php if ($mode == 'view') { ?>
        <h1>열람용 비밀번호 입력</h1>
        <form action="question_board_view.php" method="POST">
            <input type="hidden" name="idx" value="<?= $idx ?>">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호를 입력하세요" required
                value="<?= $masterPassword ?>">
            <input type="submit" class="btn btn-primary mt-2" value="확인">
        </form>
        <?php } else if ($mode == 'delete') { ?>
        <h1>삭제용 비밀번호 입력</h1>
        <form action="question_board_delete.php" method="POST">
            <input type="hidden" name="idx" value="<?= $idx ?>">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호를 입력하세요" required
                value="<?= $masterPassword ?>">
            <input type="submit" class="btn btn-primary mt-2" value="확인">
        </form>
        <?php } else if ($mode == 'edit') { ?>
        <h1>수정용 비밀번호 입력</h1>
        <form action="question_board_edit.php" method="POST">
            <input type="hidden" name="idx" value="<?= $idx ?>">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호를 입력하세요" required
                value="<?= $masterPassword ?>">
            <input type="submit" class="btn btn-primary mt-2" value="확인">
        </form>

        <?php } else if ($mode == 'download') { ?>
        <h1>다운로드용 비밀번호 입력</h1>
        <form action="question_board_download.php" method="POST">
            <input type="hidden" name="idx" value="<?= $idx ?>">
            <input type="password" name="password" class="form-control w-25" placeholder="비밀번호를 입력하세요" required
                value="<?= $masterPassword ?>">
            <input type="submit" class="btn btn-primary mt-2" value="확인">
        </form>
        <?php } ?>
    </div>
</main>



<?php
include "include/footer.php";
?>