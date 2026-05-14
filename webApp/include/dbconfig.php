<?php
$servername = 'localhost';
$dbuser = 'admin';
$dbpassword = 'tjrghks0216';
$dbname = 'inthewhiteshadow';


try {

    $db = new PDO("mysql:host={$servername};dbname={$dbname};charset=utf8mb4", $dbuser, $dbpassword);

    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // prepared statement를 지원하지 않는 경우 데이터베이스의 기능을 사용하도록 해줌
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true); // 쿼리 버퍼링을 활성화
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // pdo 객체가 에러를 처리하는 방식 설정
} catch (PDOException $e) {
    echo $e->getMessage(); // 에러 출력
}