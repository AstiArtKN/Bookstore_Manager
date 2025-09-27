<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$data = [
    'title' => 'Thêm sách'
];

layout('sidebar', $data);
layout('header',  $data);

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

    if(empty($errors)){
         $idrand = generateRandomID(10);
        // print_r($filter);
        $data = [
            'ID' => $idrand,
            'tenNguoiDung' => $filter['namelogin'],
            'ho' => $filter['firstName'],
            'tenLot' => $filter['middleName'],
            'ten' => $filter['lastName'],
            'email' => $filter['emailAddress'],
            'SDT' => $filter['phoneNumber'],
            'matKhau' => password_hash( $filter['pass'], PASSWORD_DEFAULT),
            'ngaySinh' => $filter['ngaySinh'],
            'gioiTinh' => $filter['gioiTinh'],
            'trangThai' => $filter['trangThai'],
            'quyenHanId' => $filter['quyenHanId'],
            'create_at' => date('Y:m:d H:i:s')
            

        ];
        $insertStatus = insert('nguoidung', $data);
        if($insertStatus){
            setSessionFlash('msg', 'thêm người dùng thành công!!!');
            setSessionFlash('msg_type', 'success');
        }else{
             setSessionFlash('msg', 'Thêm người dùng thất bại.');
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

<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Thêm sách</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=books&action=list" class="book-editor__add btn"><i class="fa-solid fa-list"></i> Xem DS</a>
    </div>
    <div class="user-add-wrapper">
        <div class="form-container">
            <form action="" method="POST">

                <div class="name-area">

                    <div class="form-group">
                        <label for="namelogin">ISBN</label>
                        <input type="text" id="namelogin" name="namelogin" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'namelogin');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'namelogin');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="firstName">Tên sách</label>
                        <input type="text" id="firstName" name="firstName" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'firstName');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'firstName');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="middleName">kích thước</label>
                        <input type="text" id="middleName" name="middleName" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'middleName');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'middleName');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="lastName">Số trang</label>
                        <input type="text" id="lastName" name="lastName" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'lastName');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'lastName');
                            }
                        ?>
                    </div>
                </div>

                <div class="contact-area">
                    <div class="form-group">
                        <label for="emailAddress">Email</label>
                        <input type="email" id="emailAddress" name="emailAddress" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'emailAddress');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'emailAddress');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="phoneNumber">Số Điện Thoại</label>
                        <input type="text" id="phoneNumber" name="phoneNumber" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'phoneNumber');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'phoneNumber');
                            }
                        ?>
                    </div>
                </div>

                <div class="privite-area">
                    <div class="form-group">
                        <label for="pass">Mật Khẩu</label>
                        <input type="password" id="pass" name="pass">
                    </div>

                    <div class="form-group">
                        <label for="ngaySinh">Ngày Sinh</label>
                        <input type="date" id="ngaySinh" name="ngaySinh">
                    </div>

                    <div class="form-group">
                        <label for="gioiTinh">Giới Tính</label>
                        <select id="gioiTinh" name="gioiTinh">
                            <option value="">-- Chọn --</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="trangThai">Trạng Thái</label>
                        <select id="trangThai" name="trangThai">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quyenHanId">Quyền Hạn</label>
                        <select id="quyenHanId" name="quyenHanId">
                            <?php $getQH = getAll("SELECT * FROM quyenhan");
                                foreach($getQH as $item):
                            ?>

                            <option value="<?php echo $item['ID']?>"><?php echo $item['tenQuyenHan']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit">Thêm Người Dùng</button>
            </form>
        </div>
    </div>
</div>
</div>

<?php 

layout('footer');
?>