// 주소 검색 창
function address() {
  url = "address.php";
  window.open(
    url,
    "addr",
    "width=500, height = 400,scrollbars=no, resizable = no"
  );
}

function edit_user_info() {
  const f = document.edit_user_info_form;

  if (f.password.value != "") {
    if (f.password.value != f.password2.value) {
      // 비밀번호 확인

      // 비밀번호 일치여부 확인
      alert("변경할 비밀번호가 서로 일치하지 않습니다.");
      f.password.value = "";
      f.password2.value = "";
      f.password.focus();
      return false;
    }
  }

  // 이메일 입력 부분 확인
  if (f.email.value == "") {
    alert("이메일을 입력해 주세요");
    f.email.focus();
    return false;
  }

  // 주소 입력 확인
  if (f.addr1.value == "") {
    alert("주소를 입력해 주세요");
    f.addr1.focus();
    return false;
  }

  // 상세 주소 입력 확인
  if (f.addr2.value == "") {
    alert("상세 주소를 입력해 주세요");
    f.addr2.focus();
    return false;
  }

  if (f.password_before.value == "") {
    alert("현재 비밀번호를 입력해 주세요");
    f.password_before.focus();
    return false;
  }

  f.submit();
}

document.getElementById("btn_address").addEventListener("click", address);
document.getElementById("btn_submit").addEventListener("click", edit_user_info);
