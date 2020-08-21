<?php
//Tạo mảng lưu trữ thông tin của DB
$db['db_host'] = 'localhost';
$db['db_user'] = 'root';
$db['db_pass'] = '';
$db['db_name'] = 'cms';

//Duyệt các phần tử trong mảng $db
//tạo ra các constant lưu trữ các giá trị đó
foreach($db as $key => $value) {
    define(strtoupper($key), $value);
}

$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME)
              or die("CONNECT TO DATABBASE FAILED");



?>