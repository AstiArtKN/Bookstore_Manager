<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}


$filterGet = filterData('get');

if(!empty($filterGet['token'])){
    $tokenReset = $filterGet['token'];
}


if(!empty($tokenReset)){
    //kiểm tra token có đúng không
    $checkToken = getOne("SELECT * FROM nguoidung WHERE forgot_token = '$tokenReset'");
    if(!empty($checkToken)){
        if(isPost()){
            $filter = filterData();
            $errors = [];

            //validate pass
            if(empty($filter['pass'])){
                $errors['pass']['require'] = 'vui lòng nhập mật khẩu';
            }
            else{
                if(strlen(trim($filter['pass'])) < 6){
                    $errors['pass']['Length'] = 'mật khẩu phải từ 6 ký tự';
                }
            }
            //validate repass
            if(empty($filter['pass'])){
                $errors['repass']['require'] = 'vui lòng nhập lại mật khẩu';
            }
            else{
                if(trim($filter['pass']) !== trim($filter['repass'])){
                    $errors['repass']['Like'] = 'mật khẩu nhập lại không khớp';
                }
            }
            if(empty($errors)){
                $password = password_hash($filter['pass'], PASSWORD_DEFAULT);
                $data = [
                    'matKhau' => $password,
                    'forgot_token' => null,
                    'update_at' => date('Y:m:d H:i:s')
                ];
                $condition = "ID=" . "'" .$checkToken['ID'] ."'";
                $updateStatus = update('nguoidung',$data,$condition);

                if($updateStatus){
                    //gửi mail đã đổi mật khẩu thành công
                    $emailTo = $checkToken['email'];
                    $subject = 'ĐỔI MẬT KHẨU TẠI K-BOOKS THÀNH CÔNG';
                    $content = 'Chúc mừng bạn đang thay đổi mật khẩu tại K-BOOKS thành công, </>';
                    $content .= 'Nếu không phải bạn thao tác, vui lòng báo ngay với dịch vụ CSKH! </br>';
                    $content .= 'Cảm ơn bạn đã tin tưởng và ủng hộ K-BOOKS!^^';
                    //gửi email
                    sendMail($emailTo,$subject,$content);
                    setSessionFlash('msg', 'Đổi mật khẩu thành công.');
                    setSessionFlash('msg_type', 'success');
                }
                else{
                     setSessionFlash('msg', 'Đã có lỗi xảy ra, vui lòng thử lại sau.');
                    setSessionFlash('msg_type', 'danger');
                }
                
            }else{
                setSessionFlash('msg', 'vui lòng kiểm tra dữ liệu nhập vào.');
                setSessionFlash('msg_type', 'danger');

                setSessionFlash('oldData', $filter);
                setSessionFlash('erros', $errors);
            } 
}
    }else{
        getMsg('Liên kết đã hết hạn hoặc không tồn tại','danger');
    }
    
}
else{
    getMsg('Liên kết đã hết hạn hoặc không tồn tại','danger');
}


    $msg = getSessionFlash('msg');
    $msg_type = getSessionFlash('msg_type');
    $oldData = getSessionFlash('oldData');
    $errorArr = getSessionFlash('erros');

?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/login.css" />
    <title>Đặt lại mật khẩu</title>
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
                    <?php 
                                if(!empty($msg) && !empty($msg_type)){
                                    getMsg($msg, $msg_type); 
                                }
                                
                            ?>
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Đặt lại mật khẩu mới của bạn</p>


                        </div>

                        <div class="divider d-flex align-items-center my-4">

                        </div>


                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="password" class="form-control form-control-lg" id="pass" name="pass"
                                placeholder="nhập mật khẩu mới" />
                            <?php if(!empty($errorArr)){
                                                        echo formError($errorArr, 'pass');
                                                    }?>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-3">
                            <input type="password" class="form-control form-control-lg" id="repass" name="repass"
                                placeholder="nhập lại mật khẩu mới" />
                            <?php if(!empty($errorArr)){
                                                        echo formError($errorArr, 'repass');
                                                    }?>
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">
                            <button type="submit" type="button" data-mdb-button-init data-mdb-ripple-init
                                class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Xác
                                nhận</button>
                        </div>

                    </form>
                    <p class="small fw-bold mt-2 pt-1 mb-0"> - Quay lại trang đăng nhập - <a
                            href="<?php echo _HOST_URL; ?>?module=auth&action=login" class="link-danger">Đăng
                            nhập</a></p>
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