<?php
session_start();
if (isset($_SESSION['id']) == '') {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}

$idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : '';

if (!isset($idx) || $idx == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='index.php'</script>");
}
$js_array = ['']; // js 파일 삽입용 문자열 배열

$current_tab = 'free_board';
include "include/dbconfig.php";
include "include/free_board.php";
include "include/header.php";
$board = new Free_board($db);
$board->hitInc($idx);
$boardRow = $board->view($idx);
$likers = json_decode($boardRow['likers']);

if ($_SESSION['id'] == $boardRow['id'] || $_SESSION['id'] == 'admin') {
    $_SESSION['token'] = md5(uniqid(mt_rand(), true));
}

if ($boardRow['file_type'] != '') {
    $_SESSION['token_download'] = md5(uniqid(mt_rand(), true));
}

?>


<main class="w-100 mx-auto border rounded-2 p-5">
    <h1 class="text-center">자유게시판</h1>

    <div class="vstack w-75 mx-auto">
        <div class="p-3">
            <span class="h3 fw-bolder"><?= $boardRow['subject'] ?></span>
        </div>
        <div class="d-flex border border-top-0 border-start-0 border-end-0 border-bottom-1 mx-3">
            <span>글쓴이 : <?= $boardRow['id']; ?></span>
            <span class="ms-auto">조회수 : <?= $boardRow['hit']; ?>회</span>
            <span class="mx-2">&nbsp&nbsp|&nbsp&nbsp</span>
            <span> <?= $boardRow['create_at']; ?></span>
        </div>
        <div class="p-3">
            <span><?= $boardRow['content']; ?></span>
        </div>
        <div class="p-3 d-flex justify-content-between align-items-start">
            <a class="btn btn-outline-danger <?php if ($likers != null && in_array($_SESSION['id'], $likers)) {
                echo 'active';
            } ?>" href="likes.php?idx=<?= $_GET['idx'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16"
                    height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                    <path
                        d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                </svg> 추천 : <?= $boardRow['likes'] ?></a>
            <?php if ($boardRow['file_type'] != '') { ?>
            <p><a href="free_board_download.php?idx=<?= $boardRow['idx'] ?>&token_download=<?= $_SESSION['token_download'] ?>"
                    class="btn btn-success" download>파일
                    다운로드</a></p>
            <?php } ?>
        </div>
        <div class="d-flex gap-2 p-3">
            <button class="btn btn-secondary me-auto"
                onclick="javascript:location.href='/free_board_list.php'">목록</button>
            <?php if ($_SESSION['id'] == $boardRow['id'] || $_SESSION['id'] == 'admin') { ?>
            <button class="btn btn-primary" id="btn_edit" onclick="(function(){ 
    location.href = 'free_board_edit.php?idx=<?= $boardRow['idx'] ?>';})();">수정</button>
            <button class="btn btn-danger" id="btn_delete"
                onclick="(function(){if(confirm('정말로 삭제하시겠습니까?')) {
    location.href = 'free_board_delete.php?idx=<?= $boardRow['idx'] ?>&token=<?= $_SESSION['token'] ?>';}})();">삭제</button>
            <?php } ?>
        </div>
    </div>
</main>



<?php
include "include/footer.php";
?>