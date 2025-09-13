<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$msg = '';
$msg_type = '';

if(isPost()){
    $filter = filterData();
    $errors = [];
    
   
    //validate firsNname
    if(empty(trim($filter['firstName']))){
        $errors['firstName']['require'] = 'Vui lòng nhập họ của bạn';
    }
    // }else{
        
    // }
    //validate middleName
    if(empty(trim($filter['middleName']))){
        $errors['middleName']['require'] = 'Vui lòng nhập tên đệm của bạn';
    }
    // }else{
        
    // }
    //validate lastName
    if(empty(trim($filter['lastName']))){
        $errors['lastName']['require'] = 'Vui lòng nhập tên của bạn';
    }
    // }else{
        
    // }


    //validate email
    if(empty(trim($filter['emailAddress']))){
        $errors['emailAddress']['require'] = 'Vui lòng nhập email của bạn';
    }
    else{
        // kiểm tra email đúng đinh dạng
        if(!validateEmail(trim($filter['emailAddress']))){
             $errors['emailAddress']['isEmail'] = 'Email không đúng định dạng';
        }
        else{// kiểm tra email có tồn tại không
            $email = $filter['emailAddress'];

            $checkEmail = getRows("SELECT * FROM nguoidung WHERE email = '$email' ");
            if($checkEmail > 0){//email đã tồn tại
                 $errors['emailAddress']['check'] = 'Email đã tồn tại';
            }
        }
    }

    //validate email phoneNumber
     if(empty($filter['phoneNumber'])){
        $errors['phoneNumber']['require'] = 'vui lòng nhập số điện thoại của bạn';
    }
    else{
        if(!isPhone($filter['phoneNumber'])){
            $errors['phoneNumber']['isPhone'] = 'số điện thoại không đúng định dạng';
        }
    }

     //validate namelogin
    if(empty(trim($filter['namelogin']))){
        $errors['namelogin']['require'] = 'Vui lòng nhập tên tài khoản';
    }
    else{
        // kiểm tra tên tài khoản đúng đinh dạng
        if(strlen(trim($filter['namelogin'])) < 2){
             $errors['namelogin']['Length'] = 'Tên tài khoản phải từ 2 ký tự trở lên';
        }
        else{// kiểm tra tên tài khoản có tồn tại không
            $namelogin = $filter['namelogin'];

            $checkEmail = getRows("SELECT * FROM nguoidung WHERE tenNguoiDung = '$namelogin' ");
            if($checkEmail > 0){//email đã tồn tại
                 $errors['namelogin']['check'] = 'tài khoản đã tồn tại';
            }
        }
    }

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

    
    // if(!empty($errors)){
    //         echo '<pre>';
    //         print_r($errors);
    //         echo '</pre>';
    // }
    if(empty($errors)){
        
        //table: users, data
        $data = [
            'firstName' => $filter['firstName'],
            'middleName' => $filter['middleName'],
            'lastName' => $filter['lastName'],
            'emailAddress' => $filter['emailAddress'],
            'phoneNumber' => $filter['phoneNumber'],
            'namelogin' => $filter['namelogin'],
            'pass' => password_hash( $filter['pass'],PASSWORD_DEFAULT),
        ];
        
        // $msg = 'Đăng ký thành công';
        // $msg_type = 'success';
    }else{
        $msg = 'Dữ liệu không hợp lệ hãy kiểm tra lại';
        $msg_type = 'danger';

        setSessionFlash('oldData', $filter);
        setSessionFlash('erros', $errors);
    }

    $oldData = getSessionFlash('oldData');
    $errorArr = getSessionFlash('erros');

}
?>


<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/register.css?ver=<?php rand(); ?>" />
    <title>Đăng ký</title>
</head>

<body>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">

                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">ĐĂNG KÝ</h3>
                            <?php getMsg($msg, $msg_type); ?>
                            <form method="POST" action="" enctype="multipart/form-data">

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" id="firstName" name="firstName"
                                                value="<?php echo oldData($oldData, 'firstName');?>"
                                                class="form-control form-control-lg" placeholder="Họ" />
                                        </div>
                                        <?php echo formError($errorArr, 'firstName')?>
                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" id="middleName" name="middleName"
                                                value="<?php echo oldData($oldData, 'middleName');?>"
                                                class="form-control form-control-lg" placeholder="Tên lót" />
                                        </div>
                                        <?php echo formError($errorArr, 'middleName')?>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" id="lastName" name="lastName"
                                                value="<?php echo oldData($oldData, 'lastName');?>"
                                                class="form-control form-control-lg" placeholder="Tên" />
                                        </div>
                                        <?php echo formError($errorArr, 'lastName')?>

                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="email" id="emailAddress" name="emailAddress"
                                                value="<?php echo oldData($oldData, 'emailAddress');?>"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="emailAddress">Email</label>
                                        </div>
                                        <?php echo formError($errorArr, 'emailAddress')?>


                                    </div>
                                    <div class="col-md-6 mb-4 ">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="tel" id="phoneNumber" name="phoneNumber"
                                                value="<?php echo oldData($oldData, 'phoneNumber');?>"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="phoneNumber">Số Điện Thoại</label>
                                        </div>
                                        <?php echo formError($errorArr, 'phoneNumber')?>

                                    </div>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <input type="text" id="namelogin" name="namelogin"
                                        value="<?php echo oldData($oldData, 'namelogin');?>"
                                        class="form-control form-control-lg" placeholder="tên đăng nhập" />

                                    <div class="erro">
                                        <?php echo !empty($errorArr['namelogin']) ? reset($errorArr['namelogin']) : false;?>
                                    </div>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <input type="password" id="pass" name="pass" class="form-control form-control-lg"
                                        placeholder="mật khẩu" />
                                    <?php echo formError($errorArr, 'pass')?>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <input type="password" id="repass" name="repass"
                                        class="form-control form-control-lg" placeholder="nhập lại mật khẩu" />
                                    <?php echo formError($errorArr, 'repass')?>
                                </div>

                                <div class="mt-4 pt-2">
                                    <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit"
                                        value="Đăng ký" />
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <p class="small fw-bold mt-2 pt-1 mb-0">Bạn đã có tài khoản? <a
                                            href="<?php echo _HOST_URL; ?>?module=auth&action=login"
                                            class="link-danger">Đăng nhập</a></p>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>