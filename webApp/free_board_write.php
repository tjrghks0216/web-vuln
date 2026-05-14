<?php
session_start();
if (isset($_SESSION['id']) == '') {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}
$current_tab = 'free_board';
$js_array = ['js/file.js']; // js 파일 삽입용 문자열 배열
include "include/header.php";
?>

<main class="w-75 mx-auto boscriptounded-3 p-5">
    <h1 class="text-center">게시판 글 쓰기</h1>
    <div>
        <form action="pg/free_board_process.php" enctype="multipart/form-data" name="board_form" method="POST">
            <input type="hidden" name="mode" value="input">
            <input type="text" name="subject" id="subject" class="form-control mb-3 mt-3" placeholder="제목을 입력하세요"
                autocomplete="off" maxlength="50">
            <textarea class="form-control" name="content" id="content" rows="15" placeholder="내용을 입력하세요"
                maxlength="1000"></textarea>
            <div class="mt-3">
                <input type="file" name="file" id="file" class="form-control">
            </div>
            <div class="mt-3 d-flex gap-2 justify-content-end">
                <input type="submit" class="btn btn-primary" id="btn_write_submit" value="확인">
                <button class="btn btn-secondary" id="btn_board_list">목록</button>
            </div>
        </form>

    </div>
    </div>
</main>
<?php
include "include/footer.php";