<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}

$filter = filterData('get');
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/login.css" />
    <title>Kích hoạt tài khoản</title>
</head>

<body>
    <?php 
    //đường link đúng
        if(!empty($filter['token'])):
            $token = $filter['token'];
            //kiem tra token
            $checkToken = getOne("SELECT * FROM nguoidung WHERE active_token = '$token'");
            
    ?>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/login_img.jpg" class="img-fluid"
                        alt="Sample image">
                </div>
                <?php
                if (!empty($checkToken)):
                    $data = [
                        'trangThai' => 1,
                        'active_token' => null,
                        'update_at' => date('Y-m-d H:i:s'),
                        'ID' => $checkToken['ID']

                    ];
                     $condition = "ID = :ID";
                    
                    update('nguoidung',$data, $condition);
                    ?>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form>
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Kích hoạt tài khoản thành công</p>
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">

                            <p class="small fw-bold mt-2 pt-1 mb-0"><a
                                    href="<?php echo _HOST_URL; ?>?module=auth&action=login" class="link-danger">Đăng
                                    nhập ngay</a></p>
                        </div>
                        <?php
                        else:
                            ?>
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            <p class="lead fw-normal mb-0 me-3">Kích hoạt tài khoản không thành công. Đường link đã hết
                                hạn</p>
                        </div>
                        <div class="text-center text-lg-start mt-4 pt-2">

                            <p class="small fw-bold mt-2 pt-1 mb-0"><a
                                    href="<?php echo _HOST_URL; ?>?module=auth&action=login" class="link-danger">Quay
                                    trở lại</a></p>
                        </div>
                        <?php
                        endif; ?>

                    </form>
                </div>

            </div>
        </div>
        <?php
    //đường link sai không hợp lệ
        else:
        ?>
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="<?php echo _HOST_URL_TEMPLATES; ?>/assets/images/login_img.jpg" class="img-fluid"
                            alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form>
                            <div
                                class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                                <p class="lead fw-normal mb-0 me-3">Link kích hoạt đã hết hạn hoặc không
                                    tồn tại</p>
                            </div>
                            <div class="text-center text-lg-start mt-4 pt-2">

                                <p class="small fw-bold mt-2 pt-1 mb-0"><a
                                        href="<?php echo _HOST_URL; ?>?module=auth&action=login"
                                        class="link-danger">Quay
                                        trở lại
                                    </a></p>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <?php
    endif;
    ?>
            <div
                class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-primary">

                <div class="text-white mb-3 mb-md-0">
                    Copyright © 2020. All rights reserved.
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
</body>

</html>