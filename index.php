<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();//tạo mới phiên làm việc hoặc chạy tiếp phiên đã có
ob_start();//giúp tránh trường hợp bị lỗi khi dùng hàm liên quan header, cookie


// --- CHẾ ĐỘ BẢO TRÌ HỆ THỐNG ---
$maintenance_mode = false; // true = bật, false = tắt




require_once './config.php';

if ($maintenance_mode ) {
    // Nếu không phải admin hoặc máy được phép thì chuyển hướng
    include './modules/maintenance/index.php';
    exit();
}


require_once './includes/connect.php';
require_once './includes/database.php';
require_once './includes/session.php';
require_once './modules/auth/index.php';



//email
require_once './includes/mailer/Exception.php';
require_once './includes/mailer/PHPMailer.php';
require_once './includes/mailer/SMTP.php';


require_once './includes/functions.php';
require_once './templates/layout/index.php';
// $rel = getOne("SELECT * FROM theloaisach");

// echo '<pre>';
// print_r($rel);
// echo '</pre>';
// die();

//sendMail('vohaidien70@gmail.com','test mail','nội dung đang đc test ');

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