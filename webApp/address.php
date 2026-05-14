<?php
if (isset($_GET['address']) && $_GET['address'] != NULL) {
    include "include/dbconfig.php";
    include "include/member.php";
    $mem = new Member($db);
    $addressArr = $mem->address_search($_GET['address']);
}
?>

<html lang="ko">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>주소찾기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script>
    function address_add(address) {
        opener.document.getElementById("f_addr1").value = address;
        opener.document.getElementById("f_addr2").value = '';
        window.close();
    }
    </script>
</head>

<body>
    <div class="container">
        <main class="p-3">
            <h1>주소 검색</h1>
            <p class="">( 구리시 주소만 찾을 수 있습니다.)</p>
            <form method="GET">
                <div class="d-flex gap-2">
                    <input name="address" type="text" placeholder="ex) 건원대로 또는 건원대로 41" class="form-control">
                    <input type="submit" value="검색" class="btn btn-primary">
                </div>
            </form>
            <?php
            if (isset($addressArr)) {
                echo '<ul class="list-group">';
                foreach ($addressArr as $row) {
                    $full = $row['SIDO'] . " " . $row['SIGUNGU'] . " " . $row['DORO'] . " " . $row['BUILD_NO1'] . " " . $row['BUILD_NM'];
                    echo "<a href='#' onclick='return address_add(\"$full\")'><li class='list-group-item'>$full</li></a>";
                }
                echo "</ul>";
            }

            ?>

        </main>

    </div>
</body>