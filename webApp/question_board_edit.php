<?php
session_start();
// if (isset($_SESSION['id']) == '' && $_SESSION(['id']) != 'admin') {
//     die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
// }

if (!isset($_POST['idx']) || $_POST['idx'] == '') {
    die("<script>alert('게시물 번호가 빠졌습니다.');location.href='question_board_list.php'</script>");
}
if (!isset($_POST['password']) || $_POST['password'] == '') {
    die("<script>alert('비밀번호가 빠졌습니다.');location.href='question_board_list.php';</script>");
}

$idx = $_POST['idx'];
$password = $_POST['password'];

include "include/dbconfig.php";
include "include/question_board.php";

$board = new question_board($db);
if (!$board->checkPassword($idx, $password)) {
    die("<script>alert('비밀번호가 틀렸습니다.');location.href='question_board_list.php';</script>");

}

$js_array = ['']; // js 파일 삽입용 문자열 배열
$current_tab = 'question_board';
$boardRow = $board->view($idx);

// if ($id != $result['id'] && $id != 'admin') {
//     die("<script>alert('권한이 없습니다.');location.href='question_board_list.php'</script>");
// }
include "include/header.php";
?>


<main class="w-75 mx-auto border rounded-3 p-5">
    <h1 class="text-center">게시판 글 수정</h1>
    <div>
        <form action="pg/question_board_process.php" enctype="multipart/form-data" name="board_form" method="POST">
            <div class="d-flex gap-2">
                <input type="text" id="id" name="id" class="form-control" placeholder="아이디" required
                    value="<?= $boardRow['id'] ?>">
                <input type="tel" id="contact" name="contact" class="form-control" placeholder="연락처 ex)010-1111-1111"
                    pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required value="<?= $boardRow['contact'] ?>" maxlength="20">
            </div>
            <input type="hidden" name="mode" value="edit">
            <input type="hidden" name="idx" value="<?= $idx ?>">
            <input type="hidden" name="password" value="<?= $password ?>">
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
                    onclick="(function(){location.href='question_board_list.php';})()">수정취소</a>
            </div>
        </form>

    </div>
    </div>
</main>

<?php
include "include/footer.php";