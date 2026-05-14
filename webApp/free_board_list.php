<?php
session_start();
if (isset($_SESSION['id']) == '') {
    die("<script>alert('권한이 없습니다.');location.href='index.php'</script>");
}
$current_tab = 'free_board';
$js_array = ['js/free_board.js']; // js 파일 삽입용 문자열 배열
include "include/dbconfig.php";
include "include/free_board.php";
include "include/lib.php";
include "include/header.php";

$page = (isset($_GET['page']) && $_GET['page'] != '' && is_numeric($_GET['page'])) ? $_GET['page'] : 1; // 아니면 1페이지
$sn = (isset($_GET['sn']) && $_GET['sn'] != '') ? $_GET['sn'] : '';
$sf = (isset($_GET['sf']) && $_GET['sf'] != '') ? htmlentities($_GET['sf']) : '';
$date_from = (isset($_GET['date_from']) && $_GET['date_from'] != '') ? $_GET['date_from'] : '';
$date_to = (isset($_GET['date_to']) && $_GET['date_to'] != '') ? $_GET['date_to'] : '';
$order = (isset($_GET['order']) && $_GET['order'] != '') ? $_GET['order'] : '';

$board = new Free_board($db); // 게시판 클래스
$paramArr = ['sn' => $sn, 'sf' => $sf, 'date_from' => $date_from, 'date_to' => $date_to, 'order' => $order];

$total = $board->total($paramArr);
$limit = 10;
$page_limit = 5;
$boardRs = $board->list($page, $limit, $paramArr);
$param = '';
?>
<style>
.tr {
    cursor: pointer;
}
</style>


<main class="w-100 mx-auto border rounded-2 p-5">
    <h1 class="text-center">자유게시판</h1>

    <table class="table striped table-hover mt-5">
        <colgroup>
            <col width="10%">
            <col width="50%">
            <col width="10%">
            <col width="15%">
            <col width="10%">
            <col width="5%">
        </colgroup>
        <tr>
            <th>번호</th>
            <th><a href="free_board_list.php?order=<?php echo ($order == 'subject_asc') ? 'subject_desc' : 'subject_asc' ?>"
                    class="link-primary">제목</a>
            </th>

            <th>이름</th>
            <th><a href="free_board_list.php?order=<?php echo ($order == 'create_at_asc') ? 'create_at_desc' : 'create_at_asc' ?>"
                    class="link-primary">날짜</a>
            </th>
            <th><a href="free_board_list.php?order=<?php echo ($order == 'hit_desc') ? 'hit_asc' : 'hit_desc' ?>"
                    class="link-primary">조회
                    수</a>
            </th>
            <th><a href="free_board_list.php?order=<?php echo ($order == 'likes_desc') ? 'likes_asc' : 'likes_desc' ?>"
                    class="link-primary">추천</a>
            </th>
        </tr>
        <?php
        $cnt = 0;
        $ntotal = $total - ($page - 1) * $limit;
        foreach ($boardRs as $boardRow) {
            $number = $ntotal - $cnt;
            $cnt++;
            ?>
        <tr class="tr" data-idx="<?= $boardRow['idx']; ?>">
            <td><?= $number ?></td>
            <td><?= $boardRow['subject'] ?></td>
            <td><?= $boardRow['id'] ?></td>
            <td><?= $boardRow['create_at'] ?></td>
            <td><?= $boardRow['hit'] ?></td>
            <td><?= $boardRow['likes'] ?></td>
        </tr>
        <?php
        }
        ?>
    </table>

    <div class="container my-3 w-75 d-flex gap-2">
        <select name="" id="sn" class="form-select w-25">
            <option value="1" <?php if ($sn == 1)
                echo 'selected' ?>>제목+내용</option>
            <option value="2" <?php if ($sn == 2)
                echo 'selected' ?>>제목</option>
            <option value="3" <?php if ($sn == 3)
                echo 'selected' ?>>내용</option>
            <option value="4" <?php if ($sn == 4)
                echo 'selected' ?>>글쓴이</option>
        </select>
        <input type="text" class="form-control w-50" id="sf" value="<?= $sf ?>">
        <input type="date" id="date_from" name="date_from" class="form-control w-25" value="<?= $date_from ?>">
        <input type="date" id="date_to" name="date_to" class="form-control w-25" value="<?= $date_to ?>">
        <button class="btn btn-primary w-25" id="btn_search">검색</button>
        <button class="btn btn-info w-25" id="btn_all">전체목록</button>
    </div>

    <div class="d-flex justify-content-between align-items-start">
        <?php
        if (isset($sn) && $sn != '' && isset($sf) && $sf != '') {
            $param .= '&sn=' . $sn . '&sf=' . $sf;
        }
        if ($date_from != '' && $date_to != '') {
            $param .= '&date_from=' . $date_from . '&date_to=' . $date_to;
        }

        if ($order != '') {
            $param .= '&order=' . $order;
        }
        echo my_pagination($total, $limit, $page_limit, $page, $param);
        ?>
        <button class="btn btn-primary" id="btn_write">글쓰기</button>
    </div>
</main>





<?php
include "include/footer.php";
?>