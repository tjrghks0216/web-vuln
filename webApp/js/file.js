document.getElementById("file").addEventListener("change", () => {
  let maxSize = 2 * 1024 * 1024; //* 2MB 사이즈 제한
  let fileSize = document.getElementById("file").files[0].size; //업로드한 파일용량
  console.log(fileSize);
  if (fileSize > maxSize) {
    alert("파일첨부 사이즈는 2MB 이내로 가능합니다.");
    document.getElementById("file").value = null; //업로드한 파일 제거
    console.dir(document.getElementById("file").files[0]);
    return;
  }
});
