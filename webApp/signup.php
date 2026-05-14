<?php
include "include/dbconfig.php";
include "include/member.php";
$mem = new Member($db);

$current_tab = 'signup';
$js_array = ['js/signup.js']; // js 파일 삽입용 문자열 배열
include "include/header.php";
?>


<main class="w-75 mx-auto border rounded-5 p-5" style="height: calc(100vh - 243px)">
    <h1 class="text-center mb-5">회원가입</h1>
    <form name="signup_form" method="POST" autocomplete="off" enctype="multipart/form-data"
        action="/pg/member_process.php">
        <input type="hidden" name="mode" value="input">
        <input type="hidden" name="id_chk" value="0">
        <div class="d-flex gap-2 align-items-end">
            <div>
                <label for="f_id" class="form-lable">아이디</label>
                <input type="text" name="id" id="f_id" class="form-control" placeholder="아이디를 입력해 주세요." maxlength="20">
            </div>
            <button type="button" class="btn btn-secondary" id="btn_id_check">아이디 중복 확인</button>
        </div>
        <div class="d-flex mt-3 gap-2 justify-content-between">
            <div class="flex-grow-1">
                <label for="f_password" class="form-lable">비밀번호</label>
                <input type="password" name="password" id="f_password" class="form-control" placeholder="비밀번호를 입력해 주세요."
                    maxlength="30">
            </div>
            <div class="flex-grow-1">
                <label for="f_password2" class="form-lable">비밀번호 확인</label>
                <input type="password" name="password2" id="f_password2" class="form-control"
                    placeholder="비밀번호를 입력해 주세요." maxlength="30">
            </div>

        </div>

        <div class="d-flex mt-3 gap-2 align-items-end">
            <div>
                <label for="f_email" class="form-lable">이메일</label>
                <input type="email" name="email" id="f_email" class="form-control" placeholder="이메일을 입력해 주세요."
                    maxlength="30">
            </div>
        </div>
        <div class="d-flex mt-3 gap-2 justify-content-between align-items-end">
            <div class="flex-grow-1">
                <label for="f_addr1" class="form-lable">주소</label>
                <input type="text" id="f_addr1" class="form-control" name="addr1" readonly maxlength="50">
            </div>
            <div class="flex-grow-1">
                <label for="f_addr2" class="form-lable">상세주소</label>
                <input type="text" id="f_addr2" class="form-control" placeholder="상세주소를 입력해 주세요." name="addr2"
                    maxlength="50">
            </div>
            <button type="button" id="btn_address" class="btn btn-secondary">주소 찾기</button>

        </div>



        <div class="mt-5 d-flex gap-2">
            <button type="button" class="btn btn-primary flex-grow-1" id="btn_submit">가입확인</button>
            <button type="button" onclick="javascript:location.href='index.php'"
                class="btn btn-secondary flex-grow-1">가입취소</button>

        </div>
    </form>
</main>

<?php
include "include/footer.php";