<?php
session_start();
$current_tab = 'question_board';
$js_array = ['js/file.js']; // js 파일 삽입용 문자열 배열
include "include/header.php";
?>


<main class="w-75 mx-auto border rounded-3 p-5">
    <h1 class="text-center">문의 글 쓰기</h1>
    <div>
        <form action="pg/question_board_process.php" enctype="multipart/form-data" name="board_form" method="POST">
            <div class="d-flex gap-2">
                <input type="text" id="id" name="id" class="form-control" placeholder="아이디" required maxlength="20">
                <input type="tel" id="contact" name="contact" class="form-control" placeholder="연락처 ex)010-1111-1111"
                    pattern="[0-9]{3}-[0-9]{4}-[0-9]{4}" required maxlength="20">
                <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호" required
                    maxlength="30">
            </div>
            <input type="hidden" name="mode" value="input">
            <input type="text" name="subject" id="subject" class="form-control mb-3 mt-3" placeholder="제목"
                autocomplete="off" maxlength="50">
            <textarea class="form-control" name="content" id="content" rows="15" placeholder="내용"
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