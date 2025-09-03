<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
ob_start();//giúp tránh trường hợp bị lỗi khi dùng hàm liên quan header, cookie

require_once './config.php';