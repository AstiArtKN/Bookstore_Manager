<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo _HOST_URL_TEMPLATES; ?>/assets/css/register.css" />
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
                            <form>

                                <div class="row">
                                    <div class="col-md-6 mb-4">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" id="firstName" class="form-control form-control-lg"
                                                placeholder="Họ" />
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" id="middleName" class="form-control form-control-lg"
                                                placeholder="Tên lót" />
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="text" id="lastName" class="form-control form-control-lg"
                                                placeholder="Tên" />
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 d-flex align-items-center">

                                        <div data-mdb-input-init class="form-outline datepicker w-100">
                                            <input type="date" class="form-control form-control-lg" id="birthdayDate" />
                                            <label for="birthdayDate" class="form-label">Ngày Sinh</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4">

                                        <h6 class="mb-2 pb-1">Giới tính: </h6>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="femaleGender" value="option1" checked />
                                            <label class="form-check-label" for="femaleGender">Nữ</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="maleGender" value="option2" />
                                            <label class="form-check-label" for="maleGender">Nam</label>
                                        </div>

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="otherGender" value="option3" />
                                            <label class="form-check-label" for="otherGender">Khác</label>
                                        </div>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4 pb-2">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="email" id="emailAddress"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="emailAddress">Email</label>
                                        </div>

                                    </div>
                                    <div class="col-md-6 mb-4 ">

                                        <div data-mdb-input-init class="form-outline">
                                            <input type="tel" id="phoneNumber" class="form-control form-control-lg" />
                                            <label class="form-label" for="phoneNumber">Số Điện Thoại</label>
                                        </div>

                                    </div>
                                </div>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <input type="text" id="namelogin" class="form-control form-control-lg"
                                        placeholder="tên đăng nhập" />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <input type="password" id="pass" class="form-control form-control-lg"
                                        placeholder="mật khẩu" />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-3">
                                    <input type="password" id="repass" class="form-control form-control-lg"
                                        placeholder="nhập lại mật khẩu" />
                                </div>

                                <div class="mt-4 pt-2">
                                    <input data-mdb-ripple-init class="btn btn-primary btn-lg" type="submit"
                                        value="Đăng ký" />
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <p class="small fw-bold mt-2 pt-1 mb-0">Bạn đã có tài khoản? <a href="#!"
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