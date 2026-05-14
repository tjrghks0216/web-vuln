const btn_write = document.querySelector("#btn_write");
btn_write.addEventListener("click", () => {
  self.location.href = "./question_board_write.php";
});

// 검색
const btn_search = document.querySelector("#btn_search");
btn_search.addEventListener("click", () => {
  const sf = document.querySelector("#sf");
  const sn = document.querySelector("#sn");
  const date_from = document.querySelector("#date_from");
  const date_to = document.querySelector("#date_to");

  if (sf.value == "" && (date_from.value == "" || date_to.value == "")) {
    alert("검색어를 입력바랍니다.");
    sf.focus();
    return false;
  }

  if (date_from.value != "" && date_to.value != "") {
    self.location.href =
      "./question_board_list.php?" +
      "sn=" +
      sn.value +
      "&sf=" +
      sf.value +
      "&date_from=" +
      date_from.value +
      "&date_to=" +
      date_to.value;
  } else {
    self.location.href =
      "./question_board_list.php?" + "sn=" + sn.value + "&sf=" + sf.value;
  }
});

// 전체 목록 버튼
const btn_all = document.querySelector("#btn_all");
btn_all.addEventListener("click", () => {
  self.location.href = "./question_board_list.php";
});

// 글보기
const trs = document.querySelectorAll(".tr");
trs.forEach((box) => {
  box.addEventListener("click", () => {
    self.location.href =
      "./question_board_password.php?" +
      "idx=" +
      box.dataset.idx +
      "&mode=view";
  });
});
