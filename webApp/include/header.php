<!DOCTYPE html>
<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>메인페이지</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <?php

    // 페이지마다 다른 js파일을 설정하기 위한 코드
    if (isset($js_array)) {
        foreach ($js_array as $var) {
            echo "<script src=\"$var\" defer></script>";
        }
    }


    ?>
</head>

<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/"
                class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
                <img src="/images/white_hat.png" style="width:5rem" class="me-2">
                <span class="fs-4">SK 루키즈 31기 5조 헤더헌터</span>
            </a>

            <ul class="nav nav-pills">
                <li class="nav-item"><a href="/" class="nav-link <?php echo ($current_tab == 'main') ? 'active' : '' ?>"
                        aria-current="page">메인</a></li>
                <li class="nav-item"><a href="question_board_list.php"
                        class="nav-link <?php echo ($current_tab == 'question_board') ? 'active' : '' ?>">문의게시판</a></li>
                <?php
                if (isset($_SESSION['id']) && $_SESSION['id'] != null) { ?>
                <li class="nav-item"><a href="free_board_list.php"
                        class="nav-link <?php echo ($current_tab == 'free_board') ? 'active' : '' ?>">자유게시판</a></li>

                <li class="nav-item"><a href="mypage_password.php"
                        class="nav-link <?php echo ($current_tab == 'mypage') ? 'active' : '' ?>">마이페이지
                        (<?= $_SESSION['id'] ?>)</a></li>
                <li class='nav-item'><a href='logout.php' class='nav-link'>로그아웃</a></li>
                <?php } else { ?>
                <li class='nav-item'><a href='login.php'
                        class='nav-link <?php echo ($current_tab == 'login') ? 'active' : '' ?>'>로그인</a></li>
                <li class='nav-item'><a href='signup.php'
                        class='nav-link <?php echo ($current_tab == 'signup') ? 'active' : '' ?>'>회원가입</a></li>
                <?php } ?>

            </ul>
        </header>