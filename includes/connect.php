<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

//KẾT NỐI DATABASE PDO
// const _HOST = 'localhost';
// const _DB = 'qlbansach';
// const _USER = 'root';
// const _PASS = '';
// const _DRIVER = 'mysql';

try{
    if(class_exists('PDO')){
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // XẢY RA LỖI NGOẠI LỆ
        );
        //$conn = new PDO("mysql:host=". _HOST. "; dbname=". _DB. ",$user_db,$password,$options);
        $dsn = _DRIVER . ':host='. _HOST."; dbname=". _DB;
        $conn = new PDO($dsn,_USER,_PASS,$options);
    }

}catch(Exception $ex){
    echo 'lỗi kết nối: '. $ex->getMessage();
}