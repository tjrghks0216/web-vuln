// 주소 검색 창
function address() {
  url = "address.php";
  window.open(
    url,
    "addr",
    "width=500, height = 400,scrollbars=no, resizable = no"
  );
}

// 아이디 중복 체크
function id_check() {
  const f_id = document.getElementById("f_id");
  if (f_id.value == "") {
    alert("아이디를 입력해 주세요.");
    f_id.focus();
    return false;
  }

  // ajax
  const f1 = new FormData();
  f1.append("id", f_id.value);
  f1.append("mode", "id_chk");

  const xhr = new XMLHttpRequest();
  xhr.open("POST", "./pg/member_process.php", "true");
  xhr.send(f1);

  xhr.onload = () => {
    if (xhr.status == 200) {
      const data = JSON.parse(xhr.responseText);
      if (data.result == "success") {
        document.signup_form.id_chk.value = "1";
        alert("사용이 가능한 아이디입니다.");
      } else if (data.result == "fail") {
        document.signup_form.id_chk.value = "0";
        alert("이미 사용중인 아이디입니다. 다른 아이디를 입력해 주세요");
        f_id.value = "";
        f_id.focus();
      } else if (data.result == "empty_id") {
        document.signup_form.id_chk.value = "0";
        alert("아이디가 비어 있습니다.");
        f_id.focus();
      } else if (data.result == "special_char") {
        document.signup_form.id_chk.value = "0";
        alert(
          "아이디에 특수문자 또는 공백이 포함되어 있습니다. 제거해주십시오."
        );
        f_id.value = "";
        f_id.focus();
      }
    }
  };
}

function signup() {
  const f = document.signup_form;
  if (f.id.value == "") {
    alert("아이디를 입력해 주세요.");
    f.id.focus();
    return false;
  }

  // 아이디 중복 확인 여부 체크
  if (f.id_chk.value == "0") {
    alert("아이디 중복 확인을 해주시기 바랍니다.");
    return false;
  }

  // 이름 입력 확인
  if (f.name.value == "") {
    alert("이름을 입력해 주세요.");
    f.name.focus();
    return false;
  }

  // 비밀번호 확인
  if (f.password.value == "") {
    alert("비밀번호를 입력해 주세요.");
    f.password.focus();
    return false;
  }

  if (f.password2.value == "") {
    alert("확인용 비밀번호를 입력해 주세요.");
    f.password2.focus();
    return false;
  }

  // 비밀번호 일치여부 확인
  if (f.password.value != f.password2.value) {
    alert("비밀번호가 서로 일치하지 않습니다.");
    f.password.value = "";
    f.password2.value = "";
    f.password.focus();
    return false;
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

  f.submit();
}

document.getElementById("btn_address").addEventListener("click", address);
document.getElementById("btn_id_check").addEventListener("click", id_check);
document.getElementById("btn_submit").addEventListener("click", signup);
