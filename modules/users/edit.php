<?php
if(!defined('_KTHopLe'))
{
    die('Truy cập không hợp lệ');
}
$data = [
    'title' => 'Chỉnh Sửa Người Dùng'
];

layout('sidebar', $data);
layout('header',  $data);

$getData = filterData('get');

if(!empty($getData['id'])){
    $user_id = $getData['id'];
    $detailUser = getOne("SELECT * FROM nguoidung WHERE ID = '$user_id'");
    if(empty($detailUser)){
        setSessionFlash('msg', 'Người dùng không tồn tại!');
        setSessionFlash('msg_type', 'danger');
        redirect('?module=users&action=list');
    }
}
else{
     setSessionFlash('msg', 'Có lỗi xảy ra. Vui lòng thử lại sau!');
     setSessionFlash('msg_type', 'danger');
     redirect('?module=users&action=list');
}


if(isPost()){
    $filter = filterData();
    $errors = [];
    //validate firsNname
    if(empty(trim($filter['ho']))){
        $errors['ho']['require'] = 'Vui lòng nhập họ của bạn';
    }
    // }else{
        
    // }
    //validate middleName
    if(empty(trim($filter['tenLot']))){
        $errors['tenLot']['require'] = 'Vui lòng nhập tên đệm của bạn';
    }
    // }else{
        
    // }
    //validate lastName
    if(empty(trim($filter['ten']))){
        $errors['ten']['require'] = 'Vui lòng nhập tên của bạn';
    }
    // }else{
        
    // }


    if($filter['email'] != $detailUser['email']){
         //validate email
    if(empty(trim($filter['email']))){
        $errors['email']['require'] = 'Vui lòng nhập email của bạn';
    }
    else{
        // kiểm tra email đúng đinh dạng
        if(!validateEmail(trim($filter['email']))){
             $errors['email']['isEmail'] = 'Email không đúng định dạng';
        }
        else{// kiểm tra email có tồn tại không
            $email = $filter['email'];

            $checkEmail = getRows("SELECT * FROM nguoidung WHERE email = '$email' ");
            if($checkEmail > 0){//email đã tồn tại
                 $errors['email']['check'] = 'Email đã tồn tại';
            }
        }
    }
    }
   

    //validate email phoneNumber
     if(empty($filter['SDT'])){
        $errors['SDT']['require'] = 'vui lòng nhập số điện thoại của bạn';
    }
    else{
        if(!isPhone($filter['SDT'])){
            $errors['SDT']['isPhone'] = 'số điện thoại không đúng định dạng';
        }
    }

    if($filter['tenNguoiDung'] != $detailUser['tenNguoiDung']){
         //validate namelogin
        if(empty(trim($filter['tenNguoiDung']))){
            $errors['tenNguoiDung']['require'] = 'Vui lòng nhập tên tài khoản';
        }
        else{
            // kiểm tra tên tài khoản không chứa khoảng trắng
            if (preg_match('/\s/', trim($filter['tenNguoiDung']))) {
            $errors['tenNguoiDung']['space'] = 'Tên tài khoản không được chứa khoảng trắng';
            }
            // kiểm tra tên tài khoản đúng đinh dạng
            else if(strlen(trim($filter['tenNguoiDung'])) < 2){
                $errors['tenNguoiDung']['Length'] = 'Tên tài khoản phải từ 2 ký tự trở lên';
            }
            else{// kiểm tra tên tài khoản có tồn tại không
                $namelogin = $filter['tenNguoiDung'];

                $checkEmail = getRows("SELECT * FROM nguoidung WHERE tenNguoiDung = '$namelogin' ");
                if($checkEmail > 0){//email đã tồn tại
                    $errors['tenNguoiDung']['check'] = 'tài khoản đã tồn tại';
                }
            }
        }
    }
    

    //validate pass
    if(!empty($filter['matKhau'])){
       if(strlen(trim($filter['matKhau'])) < 6){
            $errors['matKhau']['Length'] = 'mật khẩu phải từ 6 ký tự';
        }
    }

    if(empty($errors)){
        //  $idrand = generateRandomID(10);
        // print_r($filter);
        $dataUpdate = [
            'tenNguoiDung' => $filter['tenNguoiDung'],
            'ho' => $filter['ho'],
            'tenLot' => $filter['tenLot'],
            'ten' => $filter['ten'],
            'email' => $filter['email'],
            'SDT' => $filter['SDT'],
            'ngaySinh' => $filter['ngaySinh'],
            'gioitinh' => $filter['gioitinh'],
            'trangThai' => $filter['trangThai'],
            'quyenHanId' => $filter['quyenHanId'],
            'update_at' => date('Y:m:d H:i:s')
        ];

       if (!empty($filter['matKhau'])) {
            $dataUpdate['matKhau'] = password_hash($filter['matKhau'], PASSWORD_DEFAULT);
        }


        $condition = "ID=". "'$user_id'";
        $updateStatus = update('nguoidung', $dataUpdate, $condition);


        if($updateStatus){
            setSessionFlash('msg', 'Cập nhật người dùng thành công!!!');
            setSessionFlash('msg_type', 'success');
        }else{
             setSessionFlash('msg', 'Cập nhật người dùng thất bại.');
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
if(!empty($detailUser)){
    $oldData = $detailUser;
    // print_r($oldData);
}
$errorArr = getSessionFlash('errors');

?>

<div class="book-editor">
    <div class="book-editor__header">
        <h2 class="dashboard__mid-title">Chỉnh Sửa Người Dùng</h2>
        <?php 
            if(!empty($msg) && !empty($msg_type)){
                getMsg($msg, $msg_type); 
            }
                                
        ?>
        <a href="?module=users&action=list" class="book-editor__add btn"><i class="fa-solid fa-list"></i> Xem DS</a>
    </div>
    <div class="user-add-wrapper">
        <div class="form-container">
            <form action="" method="POST">

                <div class="name-area">

                    <div class="form-group">
                        <label for="tenNguoiDung">Tên Người Dùng</label>
                        <input type="text" id="tenNguoiDung" name="tenNguoiDung" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'tenNguoiDung');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'tenNguoiDung');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="ho">Họ</label>
                        <input type="text" id="ho" name="ho" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'ho');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'ho');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="tenLot">Tên Lót</label>
                        <input type="text" id="tenLot" name="tenLot" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'tenLot');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'tenLot');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="ten">Tên</label>
                        <input type="text" id="ten" name="ten" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'ten');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'ten');
                            }
                        ?>
                    </div>
                </div>

                <div class="contact-area">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'email');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'email');
                            }
                        ?>
                    </div>

                    <div class="form-group">
                        <label for="SDT">Số Điện Thoại</label>
                        <input type="text" id="SDT" name="SDT" value="<?php 
                                                    if(!empty($oldData)){
                                                        echo oldData($oldData, 'SDT');
                                                    }
                                                    
                                                ?>">
                        <?php 
                            if(!empty($errorArr)){
                                echo formError($errorArr, 'SDT');
                            }
                        ?>
                    </div>
                </div>

                <div class="privite-area">
                    <div class="form-group">
                        <label for="matKhau">Mật Khẩu</label>
                        <input type="password" id="matKhau" name="matKhau">
                        <?php if(!empty($errorArr)){
                                    echo formError($errorArr, 'matKhau');
                        }?>
                    </div>

                    <div class="form-group">
                        <label for="ngaySinh">Ngày Sinh</label>
                        <input type="date" id="ngaySinh" name="ngaySinh"
                            value="<?php echo !empty($oldData['ngaySinh']) ? date('Y-m-d', strtotime($oldData['ngaySinh'])) : ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="gioiTinh">Giới Tính</label>
                        <select id="gioiTinh" name="gioitinh">
                            <option value="">-- Chọn --</option>
                            <option value="Nam" <?php echo ($oldData['gioitinh'] == 'Nam')? 'selected' : false;?>>Nam
                            </option>
                            <option value="Nữ" <?php echo ($oldData['gioitinh'] == 'Nữ')? 'selected' : false;?>>Nữ
                            </option>
                            <option value="Khác" <?php echo ($oldData['gioitinh'] == 'Khác')? 'selected' : false;?>>Khác
                            </option>

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

                            <option value="<?php echo $item['ID']?>"
                                <?php echo ($oldData['quyenHanId'] == $item['ID'])? 'selected' : false;?>>
                                <?php echo $item['tenQuyenHan']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <button type="submit">Xác nhận</button>
            </form>
        </div>
    </div>
</div>
</div>

<?php 

layout('footer');
?>