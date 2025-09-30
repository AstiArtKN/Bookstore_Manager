<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

// Nếu đã đăng nhập rồi thì chuyển hướng ra trang chủ
if (getSession('token_login')) {
    $tokenlogin = getSession('token_login');
    $checkToken_login = getOne("SELECT * FROM token_login WHERE token = '$tokenlogin'");
    
    if (!empty($checkToken_login)) {
        // Đã đăng nhập hợp lệ
        redirect('/');
        exit;
    } else {
        // Token không còn hợp lệ => xoá session
        removeSession('token_login');
    }


    
}

/*
-validate dữ liệu nhập
-ktra dữ liệu với database
-dữ liệu khớp token_login -> insert vào bảng token_login 


-kiểm tra đăng nhập:
+gán token login lên session
+trong header -> lấy token từ session -> so sách trong bảng token_login
+nếu đúng thì đến trang đích, không đúng thì về trang login
-điều hướng ->>>>[]
-đăng nhập tài khoản ở 1 nơi tại một thời điểm
*/
if(isPost()){
    $filter = filterData();
    $errors = [];
    //validate email
    if(empty(trim($filter['name_email']))){
        $errors['name_email']['require'] = 'Vui lòng nhập email hoặc tên đăng nhập của bạn';
    }
    // else{}   
    //validate pass
    if(empty($filter['pass'])){
        $errors['pass']['require'] = 'vui lòng nhập mật khẩu';
    }
    else{
        if(strlen(trim($filter['pass'])) < 6){
            $errors['pass']['Length'] = 'mật khẩu phải từ 6 ký tự';
        }
    }

    if(empty($errors)){
        //kiểm tra dữ liệu
        $nameEmail = $filter['name_email'];
        $password = $filter['pass'];

        //nếu là email
        if(validateEmail(trim($filter['name_email']))){
            $checkLoginName = getOne("SELECT * FROM nguoidung WHERE email = '$nameEmail'");
        }
        //nếu là tên đăng nhập
        else{
            $checkLoginName = getOne("SELECT * FROM nguoidung WHERE tenNguoiDung = '$nameEmail'");
        }
        if(!empty($checkLoginName)){
            if(!empty($password)){
                $kiemtraMatKhau = password_verify($password,  $checkLoginName['matKhau']);
                if($kiemtraMatKhau){
                    //TK chỉ login ở một nơi
                //     $nguoidung_Id = $checkLoginName['ID'];
                    
                //     $checkAlready = getRows("SELECT * FROM token_login WHERE nguoidung_id = '$nguoidung_Id'");
                //     if($checkAlready > 0){
                //         setSessionFlash('msg', 'Tài khoản đang được đăng nhập ở nơi khác. Vui lòng thử lại sau.');
                //         setSessionFlash('msg_type', 'danger');
                //         redirect('?module=auth&action=login');
                //     }
                //    else{
                     //tạo token và insert vào bảng token_login
                    $token = sha1(uniqid().time());

                    //gán token lên session
                    //setSessionFlash('token_login', $token);
                    setSession('token_login', $token);

                    $data = [
                        'token' => $token,
                        'create_at' => date('Y:m:d H:i:s'),
                        'nguoidung_id' => $checkLoginName['ID']
                    ];


                    // kiểm tra tài khoản đăng nhập là khách hay qtv
                    // kiểm tra tài khoản đăng nhập là khách hay qtv
                    $inserToken = insert('token_login',$data);
                    if ($inserToken) {
                        if ($checkLoginName['quyenHanId'] === "QTV" || $checkLoginName['quyenHanId'] === "NV") {
                            // Trang dành cho quản trị viên/nhân viên
                            redirect('?module=dashboard&action=index');
                        } else {
                            // Trang dành cho khách hàng
                            
                            redirect('/');
                        }
                    } else {
                        setSessionFlash('msg', 'Đăng nhập không thành công.');
                        setSessionFlash('msg_type', 'danger');
                    }

                //    }
                }else{
                    setSessionFlash('msg', 'Tên đăng nhập hoặc mật khẩu sai');
                    setSessionFlash('msg_type', 'danger');
                }     
            }
        }
        else{
            setSessionFlash('msg', 'vui lòng kiểm tra dữ liệu nhập vào.');
            setSessionFlash('msg_type', 'danger');
        }
    }
    else{
        setSessionFlash('msg', 'vui lòng kiểm tra dữ liệu nhập vào.');
        setSessionFlash('msg_type', 'danger');

        setSessionFlash('oldData', $filter);
        setSessionFlash('errors', $errors);
    }
}
    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
    $oldData = getSessionFlash('oldData');
    $errorArr = getSessionFlash('errors');
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/login.css" />
    <title>Đăng nhập</title>
</head>

<body>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/login_img.jpg" class="img-fluid"
                        alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">

                    <form method="POST" action="" enctype="multipart/form-data">
                        <?php 
                                if(!empty($msg) && !empty($msg_type)){
                                    getMsg($msg, $msg_type); 
                                }
                                
                            ?>
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">ĐĂNG NHẬP</p>


                        </div>

                        <div class="divider d-flex align-items-center my-4">

                        </div>

                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <input type="text" id="name_email" name="name_email" class="form-control form-control-lg"
                                value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'name_email');
                                                    }
                                                    
                                                ?>" placeholder=" Email hoặc tên đăng nhập" />
                            <?php 
                                if(!empty($errorArr)){
                                    echo formError($errorArr, 'name_email');
                                }
                                ?>
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="password" id="pass" name="pass" class="form-control form-control-lg"
                                placeholder="mật khẩu" />
                            <?php 
                                if(!empty($errorArr)){
                                    echo formError($errorArr, 'pass');
                                }
                                ?>
                        </div>



                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Checkbox -->
                            <div class="form-check mb-0">
                                <input class="form-check-input me-2" type="checkbox" value="" id="remember" />
                                <label class="form-check-label" for="form2Example3">
                                    Remember me
                                </label>
                            </div>
                            <a href="<?php echo _HOST_URL; ?>?module=auth&action=forgot" class="text-body">quên mật
                                khẩu?</a>
                        </div>

                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Đăng
                                nhập</button>
                            <p class="small fw-bold mt-2 pt-1 mb-0">Bạn không có tài khoản? <a
                                    href="<?php echo _HOST_URL; ?>?module=auth&action=register" class="link-danger">Đăng
                                    ký</a></p>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0">
                Copyright © 2020. All rights reserved.
            </div>
            <!-- Copyright -->

            <!-- Right -->
            <div>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#!" class="text-white me-4">
                    <i class="fab fa-google"></i>
                </a>
                <a href="#!" class="text-white">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            </div>
            <!-- Right -->
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>