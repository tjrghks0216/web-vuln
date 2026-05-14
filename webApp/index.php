<?php
session_start();
$current_tab = 'main';
$js_array = ['']; // js 파일 삽입용 문자열 배열
include "include/header.php";
?>


<main class="w-75 mx-auto border rounded-3 p-5" style="height: calc(100vh - 243px)">
    <div>
        <?php
        if (isset($_SESSION['id']) && $_SESSION['id'] != NULL) {
            echo "<h1 class='text-center'>Hello {$_SESSION['id']}!!</h1>";
        } else {
            ?>
        <h2 class="text-center">취약점 진단 실습용 사이트입니다.</h2>
        <p class="mt-5">bootstrap을 사용하고 있으므로 페이지 스타일이 적용되지 않는다면 프록시 설정을 끄고 접속하여 주십시요.<br>이후에 다시 프록시 설정을 적용하면 됩니다.</p>
        <?php
        }
        ?>
    </div>
</main>

<?php
include "include/footer.php";