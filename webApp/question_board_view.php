<?php
session_start();
// if (isset($_SESSION['id']) == '') {
//     die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
// }

$idx = (isset($_POST['idx']) && $_POST['idx'] != '') ? $_POST['idx'] : '';
$password = (isset($_POST['password']) && $_POST['password'] != '') ? $_POST['password'] : '';

if (!isset($idx) || $idx == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='index.php'</script>");
}
if (!isset($password) || $password == '') {
    die("<script>alert('비밀번호가 빠졌습니다.');history.go(-2);</script>");
}


$js_array = ['']; // js 파일 삽입용 문자열 배열

$current_tab = 'question_board';
include "include/dbconfig.php";
include "include/question_board.php";
$board = new Question_board($db);

if (!$board->checkPassword($idx, $password)) {
    die("<script>alert('글 조회에 실패했습니다.');history.go(-2);</script>");
}
include "include/header.php";


$board->hitInc($idx);
$boardRow = $board->view($idx);
?>


<main class="w-100 mx-auto border rounded-2 p-5">
    <h1 class="text-center">문의게시판</h1>

    <div class="vstack w-75 mx-auto">
        <div class="p-3">
            <span class="h3 fw-bolder"><?= $boardRow['subject'] ?></span>
        </div>
        <div class="d-flex border border-top-0 border-start-0 border-end-0 border-bottom-1 mx-3">
            <span>글쓴이 : <?= $boardRow['id']; ?>&nbsp&nbsp|&nbsp&nbsp</span>
            <span>연락처 : <?= $boardRow['contact']; ?></span>
            <span class="ms-auto">조회수 : <?= $boardRow['hit']; ?>회</span>
            <span class="mx-2">&nbsp&nbsp|&nbsp&nbsp</span>
            <span> <?= $boardRow['create_at']; ?></span>
        </div>
        <div class="p-3">
            <span><?= $boardRow['content']; ?></span>
        </div>
        <div class="p-3 d-flex flex-row-reverse align-items-start">
            <?php if ($boardRow['file_type'] != '') { ?>
            <p><a href="question_board_password.php?idx=<?= $boardRow['idx'] ?>&mode=download"
                    class="btn btn-success">파일 다운로드</a></p>
            <?php } ?>
        </div>
        <div class="d-flex gap-2 p-3">
            <button class="btn btn-secondary me-auto"
                onclick="javascript:location.href='/question_board_list.php'">목록</button>

            <button class="btn btn-primary" id="btn_edit" onclick="(function(){ 
            location.href = 'question_board_password.php?idx=<?= $boardRow['idx'] ?>&mode=edit';})();">수정</button>
            <button class="btn btn-danger" id="btn_delete" onclick="(function(){if(confirm('정말로 삭제하시겠습니까?')) {
            location.href = 'question_board_password.php?idx=<?= $boardRow['idx'] ?>&mode=delete';}})();">삭제</button>

        </div>
    </div>
</main>



<?php
include "include/footer.php";
?>