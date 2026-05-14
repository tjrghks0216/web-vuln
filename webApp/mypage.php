<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['id'] == NULL) {
    die("<script>alert('허용되지 않은 접근입니다.');location.href='index.php';</script>");
}


include "include/dbconfig.php";
include "include/member.php";
$mem = new Member($db);
if (!isset($_POST['password']) || $_POST['password'] == '' || !$mem->login($_SESSION['id'], $_POST['password'])) {
    die("<script>alert('허용되지 않은 접근입니다.');location.href='index.php';</script>");
}
$user_info = $mem->user_info($_SESSION['id']);
$current_tab = 'mypage';
$js_array = ['js/mypage.js']; // js 파일 삽입용 문자열 배열
include "include/header.php";
?>


<main class="w-75 mx-auto border rounded-5 p-5">
    <h1 class="text-center mb-5">마이페이지</h1>
    <form name="edit_user_info_form" method="POST" autocomplete="off" enctype="multipart/form-data"
        action="/pg/member_process.php">
        <input type="hidden" name="mode" value="edit">
        <div class="d-flex gap-2 align-items-end">
            <div>
                <label for="f_id" class="form-lable">아이디</label>
                <input type="text" name="id" id="f_id" class="form-control" value="<?= $user_info['id'] ?>" readonly>
            </div>
        </div>
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="f_password" class="form-lable">변경할 비밀번호 <span class="text-danger">(변경할때만
                        입력하세요)</span></label>
                <input type="password" name="password" id="f_password" class="form-control"
                    placeholder="변경할 비밀번호를 입력해 주세요." maxlength="30">
            </div>
            <div class="flex-grow-1">
                <label for="f_password2" class="form-lable">변경할 비밀번호 확인 <span class="text-danger">(변경할때만
                        입력하세요)</span></label>
                <input type="password" name="password2" id="f_password2" class="form-control"
                    placeholder="변경할 비밀번호를 입력해 주세요." maxlength="30">
            </div>

        </div>

        <div class="d-flex mt-3 gap-2 align-items-end">
            <div>
                <label for="f_email" class="form-lable">이메일</label>
                <input type="text" name="email" id="f_email" class="form-control" placeholder="이메일을 입력해 주세요."
                    value="<?= $user_info['email'] ?>" maxlength="30">
            </div>
        </div>
        <div class="d-flex mt-3 gap-2 justify-content-between align-items-end">
            <div class="flex-grow-1">
                <label for="f_addr1" class="form-lable">주소</label>
                <input type="text" id="f_addr1" class="form-control" name="addr1" readonly
                    value="<?= $user_info['addr1'] ?>" maxlength="50">
            </div>
            <div class="flex-grow-1">
                <label for="f_addr2" class="form-lable">상세주소</label>
                <input type="text" id="f_addr2" class="form-control" placeholder="상세주소를 입력해 주세요." name="addr2"
                    value="<?= $user_info['addr2'] ?>" maxlength="50">
            </div>
            <button type="button" id="btn_address" class="btn btn-secondary">주소 찾기</button>

        </div>

        <div class="d-flex mt-3 justify-content-between">
            <div class="w-50">
                <label for="f_password_before" class="form-lable">현재 비밀번호 <span class="text-danger"> ( *
                        필수 )</span></label>
                <input type="password" name="password_before" id="f_password_before" class="form-control"
                    placeholder="현재 비밀번호를 입력해 주세요.">
            </div>
        </div>



        <div class="d-flex mt-3 gap-2">
            <button type="button" class="btn btn-primary flex-grow-1" id="btn_submit">수정확인</button>
            <button type="button" onclick="javascript:location.href='index.php'"
                class="btn btn-secondary flex-grow-1">수정취소</button>

        </div>
    </form>
</main>

<?php
include "include/footer.php";