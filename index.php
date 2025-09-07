<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();//tạo mới phiên làm việc hoặc chạy tiếp phiên đã có
ob_start();//giúp tránh trường hợp bị lỗi khi dùng hàm liên quan header, cookie

require_once './config.php';

require_once './includes/connect.php';
require_once './includes/database.php';
require_once './includes/session.php';
require_once './modules/auth/index.php';
require_once './templates/layout/index.php';
// $rel = getOne("SELECT * FROM theloaisach");

// echo '<pre>';
// print_r($rel);
// echo '</pre>';
// die();


// thiệt lập phương thức lấy biến truy cập vào thư mục

//http://localhost/D_A_MANAGER_BOOKSTORE/?module=auth&action=login
$module = _MODULES;
$action = _ACTION;

if(!empty($_GET['module'])){
    $module = $_GET['module'];
}

if(!empty($_GET['action'])){
    $action = $_GET['action'];
}

//truy cập đến thư mục trong module
$path = 'modules/' . $module . '/' . $action . '.php';
//$path ='';
//kiểm tra path có tồn tại, có dữ liệu hay không
if(!empty($path)){
    if(file_exists($path)){//kiểm tra tồn tại
        //echo 'kết nối thành công';
        require_once $path;
    }
    else{
        require_once './modules/errors/404.php';
    }
}
else {
   require_once './modules/errors/500.php';
}