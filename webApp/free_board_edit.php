<?php
session_start();
if (isset($_SESSION['id']) == '' && $_SESSION(['id']) != 'admin') {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}

$idx = (isset($_GET['idx']) && $_GET['idx'] != '') ? $_GET['idx'] : '';
$id = $_SESSION['id'];

if (!isset($idx) || $idx == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='index.php'</script>");
}
$js_array = ['']; // js 파일 삽입용 문자열 배열

$current_tab = 'free_board';
include "include/dbconfig.php";
include "include/free_board.php";
$board = new Free_board($db);
$boardRow = $board->view($idx);

$result = $board->find_writer($idx);
if ($id != $result['id'] && $id != 'admin') {
    die("<script>alert('권한이 없습니다.');location.href='free_board_list.php'</script>");
}
$_SESSION['token'] = md5(uniqid(mt_rand(), true));
include "include/header.php";
?>


<main class="w-75 mx-auto border rounded-3 p-5">
    <h1 class="text-center">게시판 글 수정</h1>
    <div>
        <form action="pg/free_board_process.php" enctype="multipart/form-data" name="board_form" method="POST">
            <input type="hidden" name="mode" value="edit">
            <input type="hidden" name="idx" value="<?= $idx ?>">
            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>">
            <input type="text" name="subject" id="subject" class="form-control mb-3 mt-3" placeholder="제목을 입력하세요"
                autocomplete="off" value="<?= $boardRow['subject'] ?>">
            <textarea class="form-control" name="content" id="content" rows="15"
                placeholder="내용을 입력하세요"><?= $boardRow['content'] ?></textarea>
            <div class="mt-3">
                <input type="file" name="file" id="file" class="form-control">
                <label for="file" class="form-lable m-1">새로운 파일을 업로드하면 교체됩니다.</label>
            </div>
            <div class="mt-3 d-flex gap-2 justify-content-end">
                <input type="submit" class="btn btn-primary" id="btn_write_submit" value="수정확인">
                <a class="btn btn-secondary" id="btn_board_list"
                    onclick="(function(){window.history.go(-1);})()">수정취소</a>
            </div>
        </form>

    </div>
    </div>
</main>

<?php
include "include/footer.php";